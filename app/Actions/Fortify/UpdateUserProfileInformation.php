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
                $fileName = base64_encode('agent_' . $input['name'] . time()) . '.png';
                $filePath = "user_profile_images/$fileName";

                // Save the image to a file
                Storage::disk('public')->put($filePath, $image);

                // Delete the old profile photo if it exists
                if ($user->profile_photo_path) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }

                // Save the new file path to the database
                $user->forceFill([
                    'profile_photo_path' => $filePath,
                ])->save();
            }

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
            // Delete the profile picture from storage
            Storage::disk('public')->delete($user->profile_photo_path);

            // Remove the path from the database
            $user->forceFill([
                'profile_photo_path' => null,
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
