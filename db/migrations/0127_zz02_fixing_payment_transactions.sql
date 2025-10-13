-- Whether the given payment transaction is testing or not can be only
-- determined when the transaction is started.
ALTER TABLE payment_transactions ALTER testing_payment DROP NOT NULL;
ALTER TABLE payment_transactions ALTER testing_payment DROP DEFAULT;
UPDATE payment_transactions SET testing_payment=NULL WHERE payment_transaction_started_at IS NULL AND payment_transaction_url IS NULL AND testing_payment=FALSE;
