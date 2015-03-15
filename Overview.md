# Introduction #

This is a high level explanation on how to use this web based tool.

# Definitions #

## Line Item ##
A line item is a entry in the tool.  It has funds and receipts associated with it.  The funds indicate money that is allocated to this line item.  Receipts indicate the expenditures that are associated with this line item.

Every line item has a parent that results in a nested structure for the items.  The root line item has children which are used as the high level budgets.  Underneath this first level all of the major line items are added.  Successive levels can be added, but should only be used for major items that require the allocation of funds under this item.  The tree is limited to a height of three.  For example: root -> Year-Budget -> Major-Event -> Sub-item

## Source ##
A source is a channel that funds are allocated to line items.  A source can be made public or private depending on user preference.  This feature can allow for tentative funding sources to not be made public.

## Company ##
A company is simply a list of the available names of companies that can be associated with receipts.

## Funds ##
Funds are monetary amounts that are associated with a specific line item and source.  The fund amount indicate that a specific source is funding a specific line item.

## Receipt ##
A receipt is an expenditure for a line item.  The receipt does not need to be associated with a specific funding source as this level of granularity is not required as part of the budget.  A receipt can be made private if desired.  Negative receipts could be used to offset expenses if income was associated with a specific line item.