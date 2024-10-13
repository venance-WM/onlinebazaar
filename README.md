## Online Bazaar | eCommerce, Shopping, Marketplace

**Contributing Guide**

1. **Fork the Repository**  
   Fork the repository on GitHub: [Online Bazaar Repository](https://github.com/CodeWithCrescent/obazaar_v8).

2. **Clone the Forked Project**  
   Open a terminal or command prompt and use the `git clone` command to download your forked repository to your local machine:

   ```sh
   git clone https://github.com/<your-username>/obazaar_v8.git
   cd obazaar_v8
   ```

3. **Configure the Environment**  
   - Copy the `.env.example` file to `.env`:

     ```sh
     cp .env.example .env
     ```

   - Edit the `.env` file to set your database configuration. Update the `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` fields with your database details:

     ```sh
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=your_database_name
     DB_USERNAME=your_database_user
     DB_PASSWORD=your_database_password
     ```

4. **Create the Database**  
   Create the database specified in your `.env` file.

5. **Install Dependencies**  
   Install the required dependencies using Composer:

   ```sh
   composer install
   ```

6. **Run Migrations**  
   Run the database migrations:

   ```sh
   php artisan migrate
   ```

7. **Seed the Database**  
   Populate the database with pre-added data by running the following command:

   ```sh
   php artisan db:seed
   ```

8. **Create a New Branch**  
   Create a new branch for your changes:

   ```sh
   git checkout -b <branch-name>
   ```

9. **Start Contributing**  
   - Edit the code in your local branch.
   - Push your changes to your created branch:

     ```sh
     git push origin <branch-name>
     ```

10. **Create a Pull Request**  
    Once you have pushed your changes, create a pull request. For more information on how to create a pull request, refer to the [GitHub documentation](https://docs.github.com/en/pull-requests).

---

## Credits

### Contributors

- **Crescent Sambila**  
  [![GitHub](https://img.shields.io/badge/GitHub-black?logo=github)](https://www.github.com/codeWithCrescent) 
  [![GitHub](https://img.shields.io/badge/WhatsApp-black?logo=whatsapp)](https://wa.me/255676827992) 
  [![LinkedIn](https://img.shields.io/badge/LinkedIn-blue?logo=linkedin)](https://www.linkedin.com/in/crescent-sambila)

- **Venance W. Mvile**  
  [![GitHub](https://img.shields.io/badge/GitHub-black?logo=github)](https://www.github.com/venance-WM) 
  [![GitHub](https://img.shields.io/badge/WhatsApp-black?logo=whatsapp)](https://wa.me/255621899959)  

### Project Owner
- **Online Bazaar Team**

###  System Users.
- **App User roles**
   - const ROLE_ADMIN= 0;
   - const ROLE_AGENT= 1;
   - const ROLE_SELLER =2;
   - const ROLE_CUSTOMER = 3;