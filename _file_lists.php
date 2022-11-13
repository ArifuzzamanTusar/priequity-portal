<?php 
// Indexing 
// $key = Array Key / document 
// $files[0] = slug
// $files[1] = Name
// $files[2] = HelpText

$required_files = array(
    'income_statement' => array("income_statement", "Income Statement", "Past five years or less starting with company establishment"),
    'balance_sheets' => array("balance_sheets", "Balance Sheets", "Past five years or less starting with company establishment"),
    'cash_flow_statements' => array("cash_flow_statements", "Cash Flow Statements", "Past five years or less starting with company establishment"),
    'tax_returns' => array("tax_returns", "Tax Returns", "Past five years or less starting with company establishment"),
    'net_worth_statement' => array("net_worth_statement", " Net Worth Statement", "Net Worth Statement/s for All Equity Owners That Have A 5% Or Higher Ownership Stake.
    "),
    'business_plan' => array("business_plan", "Business Plan", "Business Plan Including A 2 Year Forecast/Proforma & Management Bios."),
    'business_bank_statements' => array("business_bank_statements", "Business Bank Statements", "Business Plan Including A 2 Year Forecast/Proforma & Management Bios."),
    'business_bank_statements' => array("business_bank_statements", "Business Bank Statements", "Previous 5 Month’s Business Bank Statements for All Business Bank Accounts."),
    'post_closing' => array("post_closing", "Post-Closing", "Post-Closing Balance Assuming Term Sheet Terms/Rates."),
    'incorporation' => array("incorporation", "Articles of Incorporation", "Articles of Incorporation, Corporate Bylaws/Operating Agreement, & A Recent Certificate of Good Standing."),
    'stock' => array("stock", "Stock", "Capitalization Table of All Outstanding Stock Shares, Stock Warrants, & Stock Options."),
    'intellectual_property' => array("intellectual_property", "Intellectual Property", "All Registered Intellectual Property"),
);
?>