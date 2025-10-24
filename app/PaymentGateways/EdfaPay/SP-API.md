checkout integration
Version: 0.0.1
Released: 2023/12/1

Introduction#
This document describes the Checkout integration procedures between Checkout service and the website for e-commerce merchants..

General Information#
Checkout service is a fast and easy way to create a secure payment page. It allows collecting and submitting payments and sending them for processing.

To use the Checkout service on the site you have to perform integration. Checkout integration provides a set of APIs that allow customizing payment processing for the business. These protocols implement acquiring payments (purchases) using specific API interaction with the merchant websites.

The API requires request data as FormData and some API requires with JsonData

Checkout process#
Checkout payment flow is shown below.



When a Customer wants to make a purchase on your site the following happens:

Customer places an order and initiates payment on the site.
Site confirms the order and sends the payment processing request to the Checkout system with information about the order, payment and hash.
Checkout system validates the request and sends to the site the response with the redirect link.
The site redirects the Customer on the Checkout page by redirect link.
Customer selects the payment method, enters the payment data and confirms the payment. The payment method will be specifying automatically If only one method is available.
The payment processes at Payment Gateway.
Payment Gateway sends a callback to the site with the payment result.
The payment result is shown to the Customer.
The payment could be declined in case of invalid data detection.

Integration process#
Before you get an account to access Payment Platform, you must provide the following data to the Payment Platform administrator.

Data	Description
Callback URL	URL which will be receiving the notifications of the processing results of your request to Payment Platform.
It is mandatory if your account supports 3D-Secure. The length of Notification URL should not be more
than 255 symbols.
Contact email	Email address of Responsible Person who will monitor transactions, conduct refunds, etc.
With all Payment Platform POST requests at Notification URL the Merchant must return the string OK if he/she successfully received data or return ERROR.

You should get the following information from administrator to begin working with the Payment Platform.

Data	Description
CLIENT_KEY	Unique key to identify the account in Payment Platform (used as request parameter). In the administration platform this parametercorresponds to the Merchant key field
PASSWORD	Password for Client authentication in Payment Platform (used for calculating hash parameter). In the administration platform this parameter corresponds to the Password field
PAYMENT_URL	URL to request the Payment Platform
Callback Notification#
Checkout service sends the callback on the merchant notification_URL as a result of an operation.

You can receive the callback for the next operation types:

SALE
3DS
REDIRECT
REFUND
RECURRING
List of possible actions in Payment Platform#
When you make request to Payment Platform, you need to specify action that needs to be done. Possible actions are:

Action	Description
Initiate	Creates SALE or AUTH transaction
Refund	Refund transaction
STATUS	Gets status of transaction
Recurring	Creates SALE or AUTH transaction using previously used cardholder data
List of possible transaction results and statuses#
Result – value that system returns on request. Possible results are:

Result	Description
SUCCESS	Action was successfully completed in Payment Platform
DECLINED	Result of unsuccessful action in Payment Platform
REDIRECT	Additional action required from requester (Redirect to 3ds)
ACCEPTED	Action was accepted by Payment Platform, but will be completed later
ERROR	Request has errors and was not validated by Payment Platform
Status – actual status of transaction in Payment Platform. Possible statuses are:

Status	Description
3DS	The transaction awaits 3D-Secure validation
REDIRECT	The transaction is redirected
SETTLED	Successful transaction
REFUND	Transaction for which refund was made
DECLINED	Not successful transaction

Callback parameters#
Notification endpoint must be of method POST and able to accept form-data as the content type.

Successful sale response (Card Payment) #
Parameter	Description
action	SALE
result	SUCCESS
status	PENDING / PREPARE / SETTLED; only PENDING when auth = Y
order_id	Transaction ID in the Merchant's system
trans_id	Transaction ID in the Payment Platform
trans_date	Transaction date in the Payment Platform
descriptor	Descriptor from the bank, the same as cardholder will see in the bank statement
recurring_token	Recurring token (get if account support recurring sales and was initialization transaction for following recurring)
schedule_id	Schedule ID for recurring payments. It is available if schedule is used for recurring sale
card_token	If the parameter req_token was enabled Payment Platform returns the token value
amount	Order amount
currency	Currency

Unsuccessful sale response (Card Payment)#
Parameter	Description
action	SALE
result	DECLINED
status	DECLINED
order_id	Transaction ID in the Merchant's system
trans_id	Transaction ID in the Payment Platform
trans_date	Transaction date in the Payment Platform
descriptor	Descriptor from the bank, the same as cardholder will see in the bank statement
amount	Order amount
currency	Currency
decline_reason	The reason why the transaction was declined
hash	Special signature, used to validate callback

3D-Secure transaction response#
Parameter	Description
action	SALE
result	REDIRECT
status	3DS / REDIRECT
order_id	Transaction ID in the Merchant's system
trans_id	Transaction ID in the Payment Platform
trans_date	Transaction date in the Payment Platform
descriptor	Descriptor from the bank, the same as cardholder will see in the bank statement
amount	Order amount
currency	Currency
redirect_url	URL to which the Merchant should redirect the Customer
redirect_params	Object of specific 3DS parameters. It is array if redirect_params have no data. The availability of the redirect_params depends on the data transmitted by the acquirer. redirect_params may be missing. It usually happens when redirect_method = GET
redirect_method	The method of transferring parameters (POST / GET)
card	Masked card details
card_expiration_date	The method

Sale response (Apple Pay)#
Parameter	Description
id	Transaction ID in the Payment Platform
order_number	Transaction ID in the Merchant's system
order_amount	Order amount
order_currency	Order currency
order_description	Order description
hash	Must be SHA1 of MD5 encoded string (uppercased): payment_public_id + order.number + order.amount + order.currency + order.description + merchant.pass
type	(sale/refund)
status	(success/fail)

Sale response (Manafith)#
Parameter	Description
id	Transaction ID in the Payment Platform
order_number	Transaction ID in the Merchant's system
order_amount	Order amount
order_currency	Order currency
order_description	Order description
hash	Must be SHA1 of MD5 encoded string (uppercased): payment_public_id + order.number + order.amount + order.currency + order.description + merchant.pass
type	(sale/refund)
status	(success/fail)
source	(manafith)


PAYMENT OPERATIONS#
Initiate request#
Payment Platform supports two main operation type: Single Message System (SMS) and Dual Message System (DMS).

SMS is represented by SALE transaction. It is used for authorization and capture at a time. This operation is commonly used for immediate payments.

DMS is represented by AUTH and CAPTURE transactions. AUTH is used for authorization only, without capture. This operation used to hold the funds on card account (for example to check card validity).

SALE request is used to make both SALE and AUTH transactions.

If you want to make AUTH transaction, you need to use parameter auth with value Y.

This request is sent by POST as Form-Data in the background (e.g. through PHP CURL).


Initiate request

POST  https://api.edfapay.com/payment/initiate    


Request parameters#
Parameter	Description	Values	Required field
action	Sale	SALE	+
edfa_merchant_id	Unique key (client_key) Edfapay merchant key - UUID format value	xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx	+
order_id	Transaction ID in the Merchants system String up to 255 characters	String up to 255 characters	+
order_amount	The amount of the transaction	Numbers in the format XXXX.XX
Pay attention that amount format depends on currency exponent.
If exponent = 0, then amount is integer (without decimals). It used for currencies: CLP, VND, ISK, UGX, KRW, JPY.
If exponent = 3, then format: XXXX.XXX (with 3 decimals). It used for currencies: BHD, JOD, KWD, OMR, TND.	+
order_currency	Currency	3-letter code	+
order_description	Description of the transaction (product name)	String up to 1024 characters	+
req_token	Special attribute pointing for further tokenization	Y or N (default N)	-
payer_first_name	Customer's name	String up to 32 characters	+
payer_last_name	Customer's surname	String up to 32 characters	+
payer_middle_name	Customer's middle name	String up to 32 characters	-
payer_birth_date	Customer's birthday	format yyyy-MM-dd, e.g. 1970-02-17	-
payer_address	Customer's address	String up to 255 characters	+
payer_address2	The adjoining road or locality (if required) of the сustomer's address	String up to 255 characters	-
payer_country	Customer's country	2-letter code	+
payer_state	Customer's state	String up to 32 characters	-
payer_city	Customer's city	String up to 32 characters	+
payer_zip	ZIP-code of the Customer	String up to 10 characters	+
payer_email	Customer's email	String up to 256 characters	+
payer_phone	Customer's phone	String up to 32 characters	+
payer_ip	IP-address of the Customer	XXX.XXX.XXX.XXX	+
term_url_3ds	URL to which Customer should be returned after 3D-Secure	String up to 1024 characters	+
recurring_init	Initialization of the transaction with possible following recurring	Y or N (default N)	-
auth	Indicates that transaction must be only authenticated, but not captured	Y or N (default N)	-
hash	Special signature to validate your request to Payment Platform	See Initiate signature	+
*This field becomes optional if card_token is specified

If the optional parameter card_token and card data are specified, card_token will be ignored.

If the optional parameters req_token and card_token are specified, req_token will be ignored.

Request parameters#
Request with format-data
Response parameters#
Response with Json format

Recurring request#
Recurring payments are commonly used to create new transactions based on already stored cardholder information from previous operations. This request is sent by POST.


Recurring request

POST  https://api.edfapay.com/payment/recurring    

Request parameters#
Parameter	Description	Values	Required field
gwayId	String , Public transaction id of Payment Gateway	xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx	+
order_id	String , Order Id of merchant system	UUID format value	+
edfapay_merchant_id	String , Merchant Key indentifier xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx	UUID format value	+
amount	Product price. Format: XX.XX Pay attention that amount format depends on currency exponent.	If exponent = 0, then amount is integer (without decimals). It used for currencies: CLP, VND, ISK, UGX, KRW, JPY. If exponent = 3, then format: xx.xxx (with 3 decimals). It used for currencies: BHD, JOD, KWD, OMR, TND.
Example: 0.19	+
hash	Special signature to validate your request to payment platform	See Recurring Signature	+
payer_ip	Payment Payer ip platform	Example: 172.34.34.12	+
Request parameters#
Request with Json format

Response parameters#
Response with Json format

Refund request#
To make refund you can use Refund request. Use payment public ID from Payment Platform in the request.


Refund request

POST  https://api.edfapay.com/payment/refund    

Request parameters#
Parameter	Description	Values	Required field
edfapay_merchant_id	Unique key (client_key) Edfapay merchant key - Json value	xxxxx-xxxxx-xxxxx	+
gwayId	String , Public transaction id of Payment Gateway	xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx	+
trans_id	Transaction ID in the Payment Platform	String xxxx-xxxx-xxxx-xxx	+
order_id	Transaction ID in the Merchants system String up to 255 characters	String up to 255 characters	+
hash	Special signature to validate your request to Payment Platform	See Refund Signature	+
payer_ip	Cleint IP	String Example: 172.34.34.12	+
amount	String Amount to refund. It is required for particular refund. If amount is not specified the full order amount is settled by default.	Example: 0.19	+
Request parameters#
Request with Json format

Response parameters#
Response with Json format

Status request#
To get order status you can STATUS request. Use payment gway_Payment_Id from Payment Platform in the request.


Status request

POST  https://api.edfapay.com/payment/status    

Request Parameters#
Parameter	Description	Values	Required
merchant_id	Unique key (client_key) Edfapay merchant key - Json value	xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx	+
gway_Payment_Id	String , Public transaction id of Payment Gateway	xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx	+
order_id	String , Order Id of merchant system	OrderNumber10	+
order_id	Transaction ID in the Clients system	String up to 255 characters	+
hash	String	See Initiate Signature	+
Request parameters#
Request with Json format

Response parameters#
Response with Json format

Signature#
Sign is signature rule used either to validate your requests to payment platform or to validate callback from payment platform to your system.


Initiate Signature#
It must be SHA1 of MD5 encoded string and calculated by the formula below:

*sha1(md5(strtoupper(id.order.amount.currency.description.PASSWORD)))

// Use the CryptoJSvar

Example for Js
Var to_md5 = order.number + order.amount + order.currency + order.description + merchant.pass;



//Use the CryptoJS

var hash = CryptoJS.SHA1(CryptoJS.MD5(to_md5.toUpperCase()).toString());

var result = CryptoJS.enc.Hex.stringify(hash);


Recurring Signature#
It must be SHA1 of MD5 encoded string and calculated by the formula below:

*sha1(md5(strtoupper(recurring_init_trans_id.recurring_token.order_id.amount.description.merchant.pass)))

// Use the CryptoJSvar

Example for Js
Var to_md5 = recurring_init_trans_id + recurring_token + order.number + order.amount + order.description + merchant.pass;


//Use the CryptoJS

var hash = CryptoJS.SHA1(CryptoJS.MD5(to_md5.toUpperCase()).toString());

var result = CryptoJS.enc.Hex.stringify(hash);


Refund Signature #
It must be SHA1 of MD5 encoded string and calculated by the formula below:

hash = CryptoJS.SHA1(CryptoJS.MD5(to_md5.toUpperCase()).toString()); *sha1(md5(strtoupper))

// Use the CryptoJSvar

Example for Js
Var to_md5 = payment.id + amount + merchant.pass;


//Use the CryptoJS

var hash = CryptoJS.SHA1(CryptoJS.MD5(to_md5.toUpperCase()).toString());

var result = CryptoJS.enc.Hex.stringify(hash);


Status Signature#
It must be SHA1 of MD5 encoded string and calculated by the formula below:

*sha1(md5(strtoupper(recurring_init_trans_id.recurring_token.order_id.amount.description.merchant.pass)))

// Use the CryptoJSvar

Example for Js
Var to_md5 = payment.id + amount + merchant.pass;


//Use the CryptoJS

var hash = CryptoJS.SHA1(CryptoJS.MD5(to_md5.toUpperCase()).toString());

var result = CryptoJS.enc.Hex.stringify(hash);


Errors#
In case of an error you get synchronous response from Payment Platform:

Parameter	Description
result	ERROR
error_message	Error message
error_code	Error code
The list of the error codes is shown below.

Code	Description
204002	Enabled merchant mappings or MIDs not found.
204003	Payment type not supported.
204004	Payment method not supported.
204005	Payment action not supported.
204006	Payment system/brand not supported.
204007	Day MID limit is not set or exceeded.
204008	Day Merchant mapping limit is not set or exceeded.
204009	Payment type not found.
204010	Payment method not found.
204011	Payment system/brand not found.
204012	Payment currency not found.
204013	Payment action not found.
204014	Month MID limit is exceeded.
204015	Week Merchant mapping limit is exceeded.
208001	Payment not found.
208002	Not acceptable to request the 3ds for payment not in 3ds status.
208003	Not acceptable to request the capture for payment not in pending status.
208004	Not acceptable to request the capture for amount bigger than auth amount.
208005	Not acceptable to request the refund for payment not in settled or pending status.
208006	Not acceptable to request the refund for amount bigger than payment amount.
208008	Not acceptable to request the reversal for amount bigger than payment amount.
208009	Not acceptable to request the reversal for partial amount.
208010	Not acceptable to request the chargeback for amount bigger than payment's amount.
205005	Card token is invalid or not found.
205006	Card token is expired.
205007	Card token is not accessible.
400	Duplicate request.
400	Previous payment not completed.
Sample of error-response
Testing#
You can make test requests using data below. Please note, that all transactions will be processed using Test engine.

Card number	Card expiration date (MM/YYYY)	Testing / Result
4111111111111111	01/2025	This card number and card expiration date must be used for testing successful sale
Response on successful SALE request:
{action: SALE, result: SUCCESS, status: SETTLED}
Response on successful AUTH request:
{action: SALE, result: SUCCESS, status: PENDING}
2223000000000007	01/2039	This card number and card expiration date must be used for testing
Response on SALE/AUTH request:
{action: SALE, result: REDIRECT, status: REDIRECT}
Return to the system:
{action: SALE, result: DECLINED, status: DECLINED}
5123450000000008	01/2039	This card number and card expiration date must be used for testing
Response on SALE/AUTH request::
{action: SALE, result: REDIRECT, status: REDIRECT}
Return to the system:
{action: SALE, result: DECLINED, status: DECLINED}
4508750015741019	01/2039	This card number and card expiration date must be used for testing
Response on SALE/AUTH request:
{action: SALE, result: REDIRECT, status: REDIRECT}
Return to the system:
{action: SALE, result: DECLINED, status: DECLINED}





-------------------------------------------------
API Documentation
API #1: Create Merchant
Endpoint
POST localhost:8082/public/v2/merchants/
                                                
// Change the localhost to your server

Headers
Header Name	Value
apiKey	aW5mb0BlZGZhcGF5LnNhOjEyMzQ1Njc4
Content-Type	application/json
Cookie	JSESSIONID=DC95FD72A71E5EB2E95FF221F87361F5
Request Body

                                                {
                                                    "merchantName": "Afnan A",
                                                    "email": "okafnan1@gmail.com",
                                                    "phoneNumber": "+923122405392",
                                                    "sendEmail": true
                                                }
                                                
Response

                                                {
                                                    "responseCode": "200",
                                                    "responseDescription": "Public Merchant Created Successfully...",
                                                    "merchantId": "0e0b76a9-7582-4baf-90d9-7cc7c33e114e"
                                                }
                                                
API #2: Add Terminal
Endpoint
POST localhost:8082/public/v2/addTerminal/
                                                
// Change the localhost to your server

Headers
Header Name	Value
apiKey	aW5mb0BlZGZhcGF5LnNhOjEyMzQ1Njc4
Content-Type	application/json
Cookie	JSESSIONID=DC95FD72A71E5EB2E95FF221F87361F5
Request Body

                                                {
                                                    "merchantId": "45af8f60-4ac8-43a8-b7e6-1408f864807b", //use merchantId which created from Merchant API
                                                    "merchantEmail": "okafnan@gmail.com",
                                                    "onBoardingStatus": false,
                                                    "tsn": "1010101",
                                                    "terminalId": "1010101",
                                                    "hardwareSerialNumber": "1010101"
                                                }
                                                
Response

                                                {
                                                    "responseCode": "200",
                                                    "responseDescription": "Add New Terminal Successfully"
                                                }
                                                
API #3: Create User
Endpoint
POST localhost:8082/public/v2/users/
                                                
// Change the localhost to your server

Headers
Header Name	Value
apiKey	aW5mb0BlZGZhcGF5LnNhOjEyMzQ1Njc4
Content-Type	application/json
Cookie	JSESSIONID=DC95FD72A71E5EB2E95FF221F87361F5
Request Body

                                                {
                                                    "merchantId": "45af8f60-4ac8-43a8-b7e6-1408f864807b",  //use merchantId which created from Merchant API
                                                    "firstName": "Afnan Test",
                                                    "lastName": "Test21122121",
                                                    "username": "966565656500",
                                                    "email": "afnan51020@gmail.com",
                                                    "phoneNumber": "+966565656500a",
                                                    "outletId": "120853a5-07c4-4e8c-a6df-773f5e20eeaf"
                                                }
                                                
Response

                                                {
                                                    "responseCode": "200",
                                                    "responseDescription": "Public User Created Successfully...",
                                                    "userId": "60298cba-d6e4-43df-8040-d95ece4f194a"
                                                }
                                                
API #4: FilterTransactions
Overview
This API allows you to filter and retrieve transaction details based on specified criteria. It supports pagination, sorting, and filtering by various transaction attributes such as amount, date range, status, and more.

Endpoint
Authentication
This API requires the following headers for authentication:

Authorization: Base64-encoded credentials (e.g., dGVzdDEyM0BnbWFpbC5jb206RWRmYXBheUAxMjM=).
apiKey: API key for authentication (e.g., YXlvdW5lc0BlZGZhcGF5LmNvbToxMjM0QXJhZkA=).
Query Parameters
The following query parameters are supported for filtering and pagination:

Parameter	Type	Description
PageSize	Integer	Number of transactions to return per page (e.g., 10).
amountFrom	Decimal	Minimum transaction amount to filter (optional).
amountTo	Decimal	Maximum transaction amount to filter (optional).
rrn	String	Retrieval Reference Number (RRN) to filter transactions (e.g., 000244399083).
cardType	String	Type of card used for the transaction (optional).
status	String	Transaction status to filter (optional).
operationType	String	Type of operation (e.g., purchase, refund) to filter (optional).
reconciliationStatus	String	Reconciliation status to filter (optional).
startDate	Date	Start date for filtering transactions (format: YYYY-MM-DD, e.g., 2024-01-01).
endDate	Date	End date for filtering transactions (format: YYYY-MM-DD, e.g., 2025-06-12).
transactionType	String	Type of transaction to filter (optional).
merchantId	UUID	Unique identifier of the merchant (e.g., 9790555d-fa64-4f62-bfe7-2667e094ef4c).
pageNumber	Integer	Page number for pagination (e.g., 1).
sortDirection	String	Sorting direction (ASC for ascending, DESC for descending).
SortBy	String	Field to sort by (e.g., trxTimestamp).
Example Request
```bash curl --location --request GET 'https://apidev.edfapay.com/transactions/filterTransaction/v1/partner/transactions?PageSize=10&amountFrom=&rrn=000244399083&amountTo=&cardType=&status=&operationType=&reconciliationStatus=&startDate=2024-01-01&endDate=2025-06-12&transactionType=&merchantId=9790555d-fa64-4f62-bfe7-2667e094ef4c&pageNumber=1&sortDirection=DESC&SortBy=trxTimestamp' \ --header 'Authorization: dGVzdDEyM0BnbWFpbC5jb206RWRmYXBheUAxMjM=' \ --header 'apiKey: YXlvdW5lc0BlZGZhcGF5LmNvbToxMjM0QXJhZkA='


