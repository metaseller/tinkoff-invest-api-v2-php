<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: operations.proto

namespace GPBMetadata;

class Operations
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        \GPBMetadata\Common::initOnce();
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
operations.proto%tinkoff.public.invest.api.contract.v1common.protogoogle/api/field_behavior.proto"�
OperationsRequest

account_id (	B�A-
from (2.google.protobuf.TimestampH �+
to (2.google.protobuf.TimestampH�I
state (25.tinkoff.public.invest.api.contract.v1.OperationStateH�
figi (	H�B
_fromB
_toB
_stateB
_figi"Z
OperationsResponseD

operations (20.tinkoff.public.invest.api.contract.v1.Operation"�
	Operation

id (	
parent_operation_id (	
currency (	B
payment (21.tinkoff.public.invest.api.contract.v1.MoneyValue@
price (21.tinkoff.public.invest.api.contract.v1.MoneyValueD
state (25.tinkoff.public.invest.api.contract.v1.OperationState
quantity (
quantity_rest (
figi	 (	
instrument_type
 (	(
date (2.google.protobuf.Timestamp
type (	L
operation_type (24.tinkoff.public.invest.api.contract.v1.OperationTypeE
trades (25.tinkoff.public.invest.api.contract.v1.OperationTrade
	asset_uid (	
position_uid (	
instrument_uid (	S
child_operations (29.tinkoff.public.invest.api.contract.v1.ChildOperationItem"�
OperationTrade
trade_id (	-
	date_time (2.google.protobuf.Timestamp
quantity (@
price (21.tinkoff.public.invest.api.contract.v1.MoneyValue"�
PortfolioRequest

account_id (	B�A^
currency (2G.tinkoff.public.invest.api.contract.v1.PortfolioRequest.CurrencyRequestH �",
CurrencyRequest
RUB 
USD
EURB
	_currency"�
PortfolioResponseN
total_amount_shares (21.tinkoff.public.invest.api.contract.v1.MoneyValueM
total_amount_bonds (21.tinkoff.public.invest.api.contract.v1.MoneyValueK
total_amount_etf (21.tinkoff.public.invest.api.contract.v1.MoneyValueR
total_amount_currencies (21.tinkoff.public.invest.api.contract.v1.MoneyValueO
total_amount_futures (21.tinkoff.public.invest.api.contract.v1.MoneyValueH
expected_yield (20.tinkoff.public.invest.api.contract.v1.QuotationK
	positions (28.tinkoff.public.invest.api.contract.v1.PortfolioPosition

account_id (	O
total_amount_options	 (21.tinkoff.public.invest.api.contract.v1.MoneyValueJ
total_amount_sp
 (21.tinkoff.public.invest.api.contract.v1.MoneyValueQ
total_amount_portfolio (21.tinkoff.public.invest.api.contract.v1.MoneyValueZ
virtual_positions (2?.tinkoff.public.invest.api.contract.v1.VirtualPortfolioPositionF
daily_yield (21.tinkoff.public.invest.api.contract.v1.MoneyValueN
daily_yield_relative (20.tinkoff.public.invest.api.contract.v1.Quotation"+
PositionsRequest

account_id (	B�A"�
PositionsResponse@
money (21.tinkoff.public.invest.api.contract.v1.MoneyValueB
blocked (21.tinkoff.public.invest.api.contract.v1.MoneyValueN

securities (2:.tinkoff.public.invest.api.contract.v1.PositionsSecurities"
limits_loading_in_progress (H
futures (27.tinkoff.public.invest.api.contract.v1.PositionsFuturesH
options (27.tinkoff.public.invest.api.contract.v1.PositionsOptions

account_id (	"0
WithdrawLimitsRequest

account_id (	B�A"�
WithdrawLimitsResponse@
money (21.tinkoff.public.invest.api.contract.v1.MoneyValueB
blocked (21.tinkoff.public.invest.api.contract.v1.MoneyValueL
blocked_guarantee (21.tinkoff.public.invest.api.contract.v1.MoneyValue"�
PortfolioPosition
figi (	
instrument_type (	B
quantity (20.tinkoff.public.invest.api.contract.v1.QuotationQ
average_position_price (21.tinkoff.public.invest.api.contract.v1.MoneyValueH
expected_yield (20.tinkoff.public.invest.api.contract.v1.QuotationF
current_nkd (21.tinkoff.public.invest.api.contract.v1.MoneyValueW
average_position_price_pt (20.tinkoff.public.invest.api.contract.v1.QuotationBH
current_price (21.tinkoff.public.invest.api.contract.v1.MoneyValueV
average_position_price_fifo	 (21.tinkoff.public.invest.api.contract.v1.MoneyValueK
quantity_lots
 (20.tinkoff.public.invest.api.contract.v1.QuotationB
blocked (F
blocked_lots (20.tinkoff.public.invest.api.contract.v1.Quotation
position_uid (	
instrument_uid (	E

var_margin (21.tinkoff.public.invest.api.contract.v1.MoneyValueM
expected_yield_fifo (20.tinkoff.public.invest.api.contract.v1.QuotationF
daily_yield (21.tinkoff.public.invest.api.contract.v1.MoneyValue
ticker  (	"�
VirtualPortfolioPosition
position_uid (	
instrument_uid (	
figi (	
instrument_type (	B
quantity (20.tinkoff.public.invest.api.contract.v1.QuotationQ
average_position_price (21.tinkoff.public.invest.api.contract.v1.MoneyValueH
expected_yield (20.tinkoff.public.invest.api.contract.v1.QuotationM
expected_yield_fifo (20.tinkoff.public.invest.api.contract.v1.Quotation/
expire_date	 (2.google.protobuf.TimestampH
current_price
 (21.tinkoff.public.invest.api.contract.v1.MoneyValueV
average_position_price_fifo (21.tinkoff.public.invest.api.contract.v1.MoneyValueF
daily_yield (21.tinkoff.public.invest.api.contract.v1.MoneyValue
ticker  (	"�
PositionsSecurities
figi (	
blocked (
balance (
position_uid (	
instrument_uid (	
ticker (	
exchange_blocked (
instrument_type (	"�
PositionsFutures
figi (	
blocked (
balance (
position_uid (	
instrument_uid (	
ticker (	"r
PositionsOptions
position_uid (	
instrument_uid (	
ticker (	
blocked (
balance ("�
BrokerReportRequestl
generate_broker_report_request (2B.tinkoff.public.invest.api.contract.v1.GenerateBrokerReportRequestH b
get_broker_report_request (2=.tinkoff.public.invest.api.contract.v1.GetBrokerReportRequestH B	
payload"�
BrokerReportResponsen
generate_broker_report_response (2C.tinkoff.public.invest.api.contract.v1.GenerateBrokerReportResponseH d
get_broker_report_response (2>.tinkoff.public.invest.api.contract.v1.GetBrokerReportResponseH B	
payload"�
GenerateBrokerReportRequest

account_id (	B�A-
from (2.google.protobuf.TimestampB�A+
to (2.google.protobuf.TimestampB�A"/
GenerateBrokerReportResponse
task_id (	"J
GetBrokerReportRequest
task_id (	B�A
page (H �B
_page"�
GetBrokerReportResponseJ
broker_report (23.tinkoff.public.invest.api.contract.v1.BrokerReport

itemsCount (

pagesCount (
page ("�
BrokerReport
trade_id (	
order_id (	
figi (	
execute_sign (	2
trade_datetime (2.google.protobuf.Timestamp
exchange (	

class_code (	
	direction (	
name	 (	
ticker
 (	@
price (21.tinkoff.public.invest.api.contract.v1.MoneyValue
quantity (G
order_amount (21.tinkoff.public.invest.api.contract.v1.MoneyValueC
	aci_value (20.tinkoff.public.invest.api.contract.v1.QuotationM
total_order_amount (21.tinkoff.public.invest.api.contract.v1.MoneyValueL
broker_commission (21.tinkoff.public.invest.api.contract.v1.MoneyValueN
exchange_commission (21.tinkoff.public.invest.api.contract.v1.MoneyValueW
exchange_clearing_commission (21.tinkoff.public.invest.api.contract.v1.MoneyValueC
	repo_rate (20.tinkoff.public.invest.api.contract.v1.Quotation
party (	4
clear_value_date (2.google.protobuf.Timestamp2
sec_value_date (2.google.protobuf.Timestamp
broker_status (	
separate_agreement_type (	!
separate_agreement_number (	
separate_agreement_date (	
delivery_type (	"�
 GetDividendsForeignIssuerRequest�
"generate_div_foreign_issuer_report (2R.tinkoff.public.invest.api.contract.v1.GenerateDividendsForeignIssuerReportRequestH v
get_div_foreign_issuer_report (2M.tinkoff.public.invest.api.contract.v1.GetDividendsForeignIssuerReportRequestH B	
payload"�
!GetDividendsForeignIssuerResponse�
+generate_div_foreign_issuer_report_response (2S.tinkoff.public.invest.api.contract.v1.GenerateDividendsForeignIssuerReportResponseH s
div_foreign_issuer_report (2N.tinkoff.public.invest.api.contract.v1.GetDividendsForeignIssuerReportResponseH B	
payload"�
+GenerateDividendsForeignIssuerReportRequest

account_id (	B�A-
from (2.google.protobuf.TimestampB�A+
to (2.google.protobuf.TimestampB�A"Z
&GetDividendsForeignIssuerReportRequest
task_id (	B�A
page (H �B
_page"?
,GenerateDividendsForeignIssuerReportResponse
task_id (	"�
\'GetDividendsForeignIssuerReportResponsel
dividends_foreign_issuer_report (2C.tinkoff.public.invest.api.contract.v1.DividendsForeignIssuerReport

itemsCount (

pagesCount (
page ("�
DividendsForeignIssuerReport/
record_date (2.google.protobuf.Timestamp0
payment_date (2.google.protobuf.Timestamp
security_name (	
isin (	
issuer_country (	
quantity (B
dividend (20.tinkoff.public.invest.api.contract.v1.QuotationM
external_commission (20.tinkoff.public.invest.api.contract.v1.QuotationH
dividend_gross	 (20.tinkoff.public.invest.api.contract.v1.Quotation=
tax
 (20.tinkoff.public.invest.api.contract.v1.QuotationI
dividend_amount (20.tinkoff.public.invest.api.contract.v1.Quotation
currency (	"{
PortfolioStreamRequest
accounts (	O
ping_settings (28.tinkoff.public.invest.api.contract.v1.PingDelaySettings"�
PortfolioStreamResponse[
subscriptions (2B.tinkoff.public.invest.api.contract.v1.PortfolioSubscriptionResultH M
	portfolio (28.tinkoff.public.invest.api.contract.v1.PortfolioResponseH ;
ping (2+.tinkoff.public.invest.api.contract.v1.PingH B	
payload"�
PortfolioSubscriptionResultR
accounts (2@.tinkoff.public.invest.api.contract.v1.AccountSubscriptionStatus
tracking_id (	
	stream_id (	"�
AccountSubscriptionStatus

account_id (	_
subscription_status (2B.tinkoff.public.invest.api.contract.v1.PortfolioSubscriptionStatus"�
GetOperationsByCursorRequest

account_id (	B�A
instrument_id (	H �-
from (2.google.protobuf.TimestampH�+
to (2.google.protobuf.TimestampH�
cursor (	H�
limit (H�M
operation_types (24.tinkoff.public.invest.api.contract.v1.OperationTypeI
state (25.tinkoff.public.invest.api.contract.v1.OperationStateH� 
without_commissions (H�
without_trades (H�
without_overnights (H�B
_instrument_idB
_fromB
_toB	
_cursorB
_limitB
_stateB
_without_commissionsB
_without_tradesB
_without_overnights"�
GetOperationsByCursorResponse
has_next (
next_cursor (	C
items (24.tinkoff.public.invest.api.contract.v1.OperationItem"�	
OperationItem
cursor (	
broker_account_id (	

id (	
parent_operation_id (	
name (	(
date (2.google.protobuf.TimestampB
type (24.tinkoff.public.invest.api.contract.v1.OperationType
description (	D
state (25.tinkoff.public.invest.api.contract.v1.OperationState
instrument_uid (	
figi  (	
instrument_type! (	N
instrument_kind" (25.tinkoff.public.invest.api.contract.v1.InstrumentType
position_uid# (	B
payment) (21.tinkoff.public.invest.api.contract.v1.MoneyValue@
price* (21.tinkoff.public.invest.api.contract.v1.MoneyValueE

commission+ (21.tinkoff.public.invest.api.contract.v1.MoneyValue@
yield, (21.tinkoff.public.invest.api.contract.v1.MoneyValueH
yield_relative- (20.tinkoff.public.invest.api.contract.v1.QuotationF
accrued_int. (21.tinkoff.public.invest.api.contract.v1.MoneyValue
quantity3 (
quantity_rest4 (
quantity_done5 (4
cancel_date_time8 (2.google.protobuf.Timestamp
cancel_reason9 (	O
trades_info= (2:.tinkoff.public.invest.api.contract.v1.OperationItemTrades
	asset_uid@ (	S
child_operationsA (29.tinkoff.public.invest.api.contract.v1.ChildOperationItem"`
OperationItemTradesI
trades (29.tinkoff.public.invest.api.contract.v1.OperationItemTrade"�
OperationItemTrade
num (	(
date (2.google.protobuf.Timestamp
quantity (@
price (21.tinkoff.public.invest.api.contract.v1.MoneyValue@
yield (21.tinkoff.public.invest.api.contract.v1.MoneyValueH
yield_relative (20.tinkoff.public.invest.api.contract.v1.Quotation"�
PositionsStreamRequest
accounts (	
with_initial_positions (O
ping_settings (28.tinkoff.public.invest.api.contract.v1.PingDelaySettings"�
PositionsStreamResponse[
subscriptions (2B.tinkoff.public.invest.api.contract.v1.PositionsSubscriptionResultH G
position (23.tinkoff.public.invest.api.contract.v1.PositionDataH ;
ping (2+.tinkoff.public.invest.api.contract.v1.PingH U
initial_positions (28.tinkoff.public.invest.api.contract.v1.PositionsResponseH B	
payload"�
PositionsSubscriptionResultT
accounts (2B.tinkoff.public.invest.api.contract.v1.PositionsSubscriptionStatus
tracking_id (	
	stream_id (	"�
PositionsSubscriptionStatus

account_id (	f
subscription_status (2I.tinkoff.public.invest.api.contract.v1.PositionsAccountSubscriptionStatus"�
PositionData

account_id (	D
money (25.tinkoff.public.invest.api.contract.v1.PositionsMoneyN

securities (2:.tinkoff.public.invest.api.contract.v1.PositionsSecuritiesH
futures (27.tinkoff.public.invest.api.contract.v1.PositionsFuturesH
options (27.tinkoff.public.invest.api.contract.v1.PositionsOptions(
date (2.google.protobuf.Timestamp"�
PositionsMoneyJ
available_value (21.tinkoff.public.invest.api.contract.v1.MoneyValueH
blocked_value (21.tinkoff.public.invest.api.contract.v1.MoneyValue"p
ChildOperationItem
instrument_uid (	B
payment (21.tinkoff.public.invest.api.contract.v1.MoneyValue*�
OperationState
OPERATION_STATE_UNSPECIFIED 
OPERATION_STATE_EXECUTED
OPERATION_STATE_CANCELED
OPERATION_STATE_PROGRESS*�
OperationType
OPERATION_TYPE_UNSPECIFIED 
OPERATION_TYPE_INPUT
OPERATION_TYPE_BOND_TAX$
 OPERATION_TYPE_OUTPUT_SECURITIES
OPERATION_TYPE_OVERNIGHT
OPERATION_TYPE_TAX&
"OPERATION_TYPE_BOND_REPAYMENT_FULL
OPERATION_TYPE_SELL_CARD
OPERATION_TYPE_DIVIDEND_TAX
OPERATION_TYPE_OUTPUT	!
OPERATION_TYPE_BOND_REPAYMENT
!
OPERATION_TYPE_TAX_CORRECTION
OPERATION_TYPE_SERVICE_FEE
OPERATION_TYPE_BENEFIT_TAX
OPERATION_TYPE_MARGIN_FEE
OPERATION_TYPE_BUY
OPERATION_TYPE_BUY_CARD#
OPERATION_TYPE_INPUT_SECURITIES
OPERATION_TYPE_SELL_MARGIN
OPERATION_TYPE_BROKER_FEE
OPERATION_TYPE_BUY_MARGIN
OPERATION_TYPE_DIVIDEND
OPERATION_TYPE_SELL
OPERATION_TYPE_COUPON
OPERATION_TYPE_SUCCESS_FEE$
 OPERATION_TYPE_DIVIDEND_TRANSFER%
!OPERATION_TYPE_ACCRUING_VARMARGIN(
$OPERATION_TYPE_WRITING_OFF_VARMARGIN
OPERATION_TYPE_DELIVERY_BUY 
OPERATION_TYPE_DELIVERY_SELL
OPERATION_TYPE_TRACK_MFEE
OPERATION_TYPE_TRACK_PFEE"
OPERATION_TYPE_TAX_PROGRESSIVE \'
#OPERATION_TYPE_BOND_TAX_PROGRESSIVE!+
\'OPERATION_TYPE_DIVIDEND_TAX_PROGRESSIVE"*
&OPERATION_TYPE_BENEFIT_TAX_PROGRESSIVE#-
)OPERATION_TYPE_TAX_CORRECTION_PROGRESSIVE$\'
#OPERATION_TYPE_TAX_REPO_PROGRESSIVE%
OPERATION_TYPE_TAX_REPO& 
OPERATION_TYPE_TAX_REPO_HOLD\'"
OPERATION_TYPE_TAX_REPO_REFUND(,
(OPERATION_TYPE_TAX_REPO_HOLD_PROGRESSIVE).
*OPERATION_TYPE_TAX_REPO_REFUND_PROGRESSIVE*
OPERATION_TYPE_DIV_EXT+(
$OPERATION_TYPE_TAX_CORRECTION_COUPON,
OPERATION_TYPE_CASH_FEE-
OPERATION_TYPE_OUT_FEE.!
OPERATION_TYPE_OUT_STAMP_DUTY/
OPERATION_TYPE_OUTPUT_SWIFT2
OPERATION_TYPE_INPUT_SWIFT3#
OPERATION_TYPE_OUTPUT_ACQUIRING5"
OPERATION_TYPE_INPUT_ACQUIRING6!
OPERATION_TYPE_OUTPUT_PENALTY7
OPERATION_TYPE_ADVICE_FEE8
OPERATION_TYPE_TRANS_IIS_BS9
OPERATION_TYPE_TRANS_BS_BS:
OPERATION_TYPE_OUT_MULTI;
OPERATION_TYPE_INP_MULTI<!
OPERATION_TYPE_OVER_PLACEMENT=
OPERATION_TYPE_OVER_COM>
OPERATION_TYPE_OVER_INCOME?$
 OPERATION_TYPE_OPTION_EXPIRATION@$
 OPERATION_TYPE_FUTURE_EXPIRATIONA*�
PortfolioSubscriptionStatus-
)PORTFOLIO_SUBSCRIPTION_STATUS_UNSPECIFIED )
%PORTFOLIO_SUBSCRIPTION_STATUS_SUCCESS3
/PORTFOLIO_SUBSCRIPTION_STATUS_ACCOUNT_NOT_FOUND0
,PORTFOLIO_SUBSCRIPTION_STATUS_INTERNAL_ERROR*�
"PositionsAccountSubscriptionStatus-
)POSITIONS_SUBSCRIPTION_STATUS_UNSPECIFIED )
%POSITIONS_SUBSCRIPTION_STATUS_SUCCESS3
/POSITIONS_SUBSCRIPTION_STATUS_ACCOUNT_NOT_FOUND0
,POSITIONS_SUBSCRIPTION_STATUS_INTERNAL_ERROR2�
OperationsService�
GetOperations8.tinkoff.public.invest.api.contract.v1.OperationsRequest9.tinkoff.public.invest.api.contract.v1.OperationsResponse�
GetPortfolio7.tinkoff.public.invest.api.contract.v1.PortfolioRequest8.tinkoff.public.invest.api.contract.v1.PortfolioResponse�
GetPositions7.tinkoff.public.invest.api.contract.v1.PositionsRequest8.tinkoff.public.invest.api.contract.v1.PositionsResponse�
GetWithdrawLimits<.tinkoff.public.invest.api.contract.v1.WithdrawLimitsRequest=.tinkoff.public.invest.api.contract.v1.WithdrawLimitsResponse�
GetBrokerReport:.tinkoff.public.invest.api.contract.v1.BrokerReportRequest;.tinkoff.public.invest.api.contract.v1.BrokerReportResponse�
GetDividendsForeignIssuerG.tinkoff.public.invest.api.contract.v1.GetDividendsForeignIssuerRequestH.tinkoff.public.invest.api.contract.v1.GetDividendsForeignIssuerResponse�
GetOperationsByCursorC.tinkoff.public.invest.api.contract.v1.GetOperationsByCursorRequestD.tinkoff.public.invest.api.contract.v1.GetOperationsByCursorResponse2�
OperationsStreamService�
PortfolioStream=.tinkoff.public.invest.api.contract.v1.PortfolioStreamRequest>.tinkoff.public.invest.api.contract.v1.PortfolioStreamResponse0�
PositionsStream=.tinkoff.public.invest.api.contract.v1.PositionsStreamRequest>.tinkoff.public.invest.api.contract.v1.PositionsStreamResponse0Ba
ru.tinkoff.piapi.contract.v1PZ./;investapi�TIAPI�Tinkoff.InvestApi.V1�Tinkoff\\Invest\\V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

