<?php
/**
 * Represents a currency with its name, ISO code, symbol, exchange rate, and transaction history.
 * @package Money
 */
class Money
{
    /**
     * @var string The name of the currency.
     */
    private $name;

    /**
     * @var string The ISO code of the currency.
     */
    private $iso;

    /**
     * @var string The symbol of the currency.
     */
    private $symbol;

    /**
     * @var float The exchange rate of the currency.
     */
    private $exchange_rate;

    /**
     * @var array The array of transactions for the currency.
     */
    private $transactions = [];

    /**
     * @var array The array of conversion histories for the currency.
     */
    private $converts = [];

    /**
     * Constructs a new Money object.
     *
     * @param string $name The name of the currency.
     * @param string $iso The ISO code of the currency.
     * @param string $symbol The symbol of the currency.
     * @param float $exchange_rate The exchange rate of the currency.
     */
    public function __construct($name, $iso, $symbol, $exchange_rate)
    {
        $this->name = $name;
        $this->iso = $iso;
        $this->symbol = $symbol;
        $this->exchange_rate = $exchange_rate;
    }

    /**
     * Returns the metadata of the currency.
     *
     * @return array The metadata of the currency.
     */
    public function get_meta()
    {
        return [
            'name' => $this->name,
            'iso' => $this->iso,
            'symbol' => $this->symbol,
            'exchangeRate' => $this->exchange_rate
        ];
    }

    /**
     * Adds a transaction to the currency.
     *
     * @param int|float $amount The amount of the transaction.
     * @param bool $type The type of the transaction. True for credit, false for debit.
     * @return string The transaction ID.
     */
    public function add_transaction (int|float $amount, bool $type)
    {
        if (!$type && $amount > $this->balance()) {
            return 'Insufficient balance to perform debit transaction of ' . $amount . ' ' . $this->iso . '.';
        }
        $date = date('Y-m-d H:i:s');
        $this->transactions[] = [
            'id' => $this->generate_trx_id(),
            'amount' => $amount,
            'type' => $type ? 'credit' : 'debit',
            'date' => $date
        ];
        return end($this->transactions)['id'];
    }

    /**
     * Generates a unique transaction ID.
     *
     * @return string The generated transaction ID.
     */
    private function generate_trx_id()
    {
        return md5(uniqid());
    }

    /**
     * Returns all transactions of the currency.
     *
     * @return array The array of transactions.
     */
    public function get_transactions()
    {
        return $this->transactions;
    }

    /**
     * Returns a specific transaction by its ID.
     *
     * @param string $id The ID of the transaction.
     * @return array|null The transaction with the specified ID, or null if not found.
     */
    public function get_transaction(string $id)
    {
        foreach ($this->transactions as $trx) {
            if ($trx['id'] == $id) {
                return $trx;
            }
        }
        return null;
    }

    /**
     * Converts an amount of the currency to another currency.
     *
     * @param Money $money The target currency to convert to.
     * @param int|float $amount The amount to convert.
     * @return float The converted amount.
     */
    public function convert_to(Money $money, int|float $amount)
    {
        $converted_amount = round($amount * (1 / $money->exchange_rate) * $this->exchange_rate, 2);
        $this->converts[] = [
            'from' => $this->iso,
            'to' => $money->iso,
            'amount' => $amount,
            'convertedAmount' => $converted_amount
        ];
        return $converted_amount;
    }

    /**
     * Returns the conversion histories of the currency.
     *
     * @return array The array of conversion histories.
     */
    public function convert_histories()
    {
        return $this->converts;
    }

    /**
     * Returns the total credit amount of the currency.
     *
     * @return int|float The total credit amount.
     */
    public function total_credit()
    {
        $total = 0;
        foreach ($this->transactions as $trx) {
            if ($trx['type'] == 'credit') {
                $total += $trx['amount'];
            }
        }
        return $total;
    }

    /**
     * Returns the total debit amount of the currency.
     *
     * @return int|float The total debit amount.
     */
    public function total_debit()
    {
        $total = 0;
        foreach ($this->transactions as $trx) {
            if ($trx['type'] == 'debit') {
                $total += $trx['amount'];
            }
        }
        return $total;
    }

    /**
     * Returns the total balance of the currency.
     *
     * @return int|float The total balance.
     */
    public function balance()
    {
        return $this->total_credit() - $this->total_debit();
    }

    /**
     * Returns the name of the currency.
     *
     * @return string The name of the currency.
     */
    public function get_name()
    {
        return $this->name;
    }

    /**
     * Returns the ISO code of the currency.
     *
     * @return string The ISO code of the currency.
     */
    public function get_iso()
    {
        return $this->iso;
    }

    /**
     * Returns the symbol of the currency.
     *
     * @return string The symbol of the currency.
     */
    public function get_symbol()
    {
        return $this->symbol;
    }
}