# php-money
A PHP Class that will create a new type called Money and will handle all the money related tasks

## Usage

To use the Money class, follow these steps:

1. Install the Php Money package from Composer:

    ```terminal
    composer require zisunal/php-money
    ```

2. Use the money class in your project:

    ```php
    use Zisunal\Money;
    ```

3. Create a new instance of the Money class:

    ```php
    $money = new Money('Money Name', 'Money ISO Code', 'Money Symbol', 'Exchange Rate with USD');
    ```

    The constructor takes four arguments: Money Name, Money ISO Code, Money Symbol, and Exchange Rate with USD

4. Perform money-related tasks using the available methods using the examples of index.php:

5. Enjoy using the Money class for all your money-related tasks!

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Contribution

Contributions are welcome! If you would like to contribute to this project, please follow these guidelines:

1. Fork the repository and create a new branch.
2. Make your changes and ensure that the code passes all tests.
3. Submit a pull request with a clear description of your changes.

Thank you for considering contributing to php-money!
