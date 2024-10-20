<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Storage;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update(User $user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:15'],
            // 'whatsapp' => ['nullable', 'string', 'max:15'],
            'profile' => ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'],
            'cropped_image' => ['nullable', 'string'],
        ])->validate();

        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $input);
        } else {
           // Get the base64 data
    $croppedImage = $input['cropped_image'];

    if ($croppedImage) {
        // Extract the image data from the base64 string
        $imageData = explode(',', $croppedImage);
        $imageBase64 = $imageData[1];

        // Decode the image data
        $image = base64_decode($imageBase64);

        // Create a unique file name for the image
        $fileName = 'admin_' . base64_encode($input['name'] . time()) . '.png';
        $filePath = "images/user_profile_images/$fileName"; // Update the path

        // Save the image to a file using traditional file handling
        file_put_contents(public_path($filePath), $image);

        // Delete the old profile photo if it exists
        if ($user->profile_photo_path && file_exists(public_path($user->profile_photo_path))) {
            unlink(public_path($user->profile_photo_path));
        }

        // Save only the file name to the database
        $user->forceFill([
            'profile_photo_path' => $fileName, // Store only the file name, not the full path
        ])->save();
    }

    // Update the user's other details
    $user->forceFill([
        'name' => $input['name'],
        'email' => $input['email'],
        'phone' => $input['phone'],
    ])->save();

    // $user->sellerDetail->forceFill(['whatsapp_number' => $input['whatsapp']])->save();
}
        
    }

    public function removeProfilePicture(User $user)
    {
        if ($user->profile_photo_path) {
            // Delete the profile picture using traditional file handling
            $filePath = public_path('images/user_profile_images/' . $user->profile_photo_path);
            
            if (file_exists($filePath)) {
                unlink($filePath); // Remove the file from the server
            }
    
            // Remove the path from the database
            $user->forceFill([
                'profile_photo_path' => null, // Clear the path in the database
            ])->save();
        }
    }
    
    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
