Quote = {
    // Called on document ready
    init() {
        // console.log('Quote init', this)
        Quote.templateEditLineItem = document.getElementById('template-edit-line-item').innerHTML
        Quote.templateEditLIQtySection = document.getElementById('template-edit-li-qty-section').innerHTML
        Quote.templateEditLIQtySectionRow = document.getElementById('template-edit-li-qty-section-row').innerHTML
        Quote.lineItemDiv$ = $('#quote-edit-line-items')
        Quote.loadedLineItems = JSON.parse($('input[name="line-items-json"]').val()) ?? [];
        console.log('Quote.loadedLineItems', Quote.loadedLineItems)
        Quote.activeLineItem$ = null
        Quote.searchModalLoaded = false
        Quote.displayLoadedLineItems()
    },

    // Existing quote data is found in #line-items-json
    // Take this data and build the html elements to represent it
    displayLoadedLineItems() {
        for (const lineItem of Quote.loadedLineItems) {
            Quote.buildNewLineItemEl(lineItem)
        }
    },

    // Take the current form data for the line items
    // and save it as json in #line-items-json
    prepareLineItemSaveData() {
        let itemIndex = 0
        const lineItems = Quote.lineItemDiv$.find('.qe-line-item').toArray().map((lineItemEl) => {
            const lineItemEl$ = $(lineItemEl)
            const qtyData = Quote.qtyDataFromLineItemEl(lineItemEl$)
            const qtys = qtyData.map(q => q.qty)
            // Need to make sure we save "Show in price includes?"
            let costComponents = lineItemEl$.data('part-data').costComponents
            for (const cost of costComponents) {
                const costRow = lineItemEl$.find('.qe-cost-row').toArray().find(row => $(row).data('costId') === cost.costId)
                cost.priceIncludes = !!$(costRow).find('.qe-price-includes').prop('checked')
            }
            itemIndex++
            return {
                part_id: lineItemEl$.data('part-id'),
                code: lineItemEl$.find('.qe-supplier-code').text(),
                name: lineItemEl$.find('.qe-item-name').val(),
                desc: lineItemEl$.find('.qe-item-description p').text(),
                image: lineItemEl$.find('.qe-hero-image').attr('src'),
                line_item_index: itemIndex,
                qtys: qtys,
                qty_data: qtyData,
                costs: lineItemEl$.data('part-data').costComponents,
                custom_values: Quote.lineItemCustomValues(lineItemEl$)
            }
        })
        $('input[name="line-items-json"]').val(JSON.stringify(lineItems))
        console.log('Saving line items', lineItems)
    },

    // TODO: Finish this
    // incomplete
    lineItemCustomValues(lineItemEl$) {
        let customValues = []
        for (const customInputEl$ of lineItemEl$.find('.custom-value').toArray().map(el => $(el))) {
            const costRow$ = $(customInputEl$.parents('.qe-qty-row'))
            const costId = costRow$.data('cost-id')
            const qtySectionEl$ = $(costRow$.parents('.qe-qty-section'))
            const qty = qtySectionEl$.data('qty')
            let fieldName = ''
            if (customInputEl$.hasClass('qe-component-unit-cost'))
                fieldName = 'unit_cost'
            if (customInputEl$.hasClass('qe-component-unit-sell'))
                fieldName = 'unit_sell'
            else if (customInputEl$.hasClass('qe-component-fixed-cost'))
                fieldName = 'fixed_cost'
            else if (customInputEl$.hasClass('qe-component-setup-sell'))
                fieldName = 'setup_sell'
            else if (customInputEl$.hasClass('qe-component-freight-sell'))
                fieldName = 'freight_sell'
            else if (customInputEl$.hasClass('qe-component-freight-cost'))
                fieldName = 'freight_cost'
            customValues.push({ qty: qty, cost_id: costId, field: fieldName, value: customInputEl$.data('custom-value') })
        }
        return customValues
    },

    qtyDataFromLineItemEl(lineItemEl$) {
        let qtyRows = lineItemEl$.find('.qe-qty-section').toArray().map(qtySectionEl => {
            const qtySectionEl$ = $(qtySectionEl)

            return {
                qty: parseInt(qtySectionEl$.data('qty')),
                markup: parseFloat(qtySectionEl$.find('.qe-input-target-markup').val()),
                totals: qtySectionEl$.data('qtyTotals')
            }
        })
        // If user had edited qtys, they may be out of order
        return qtyRows.sort((a, b) => a.qty - b.qty)
    },

    // Called when "Add item to quote" button clicked.
    // Prompts user to search then select product before actually creating a new line item
    addLineItem() {
        Quote.activeLineItem$ = null
        Quote.showPartSearchDialog()
    },

    // Delete selected line item from quote
    deleteLineItem(buttonEl) {
        const unwantedLineItemEl$ = $(buttonEl).parents('.qe-line-item')
        if (unwantedLineItemEl$.hasClass('to-be-deleted')) {
            unwantedLineItemEl$.remove()
            Quote.calcQuoteSummaryTotals()
        } else {
            unwantedLineItemEl$.addClass('to-be-deleted')
        }
    },

    cancelDeleteLineItem(buttonEl) {
        const unwantedLineItemEl$ = $(buttonEl).parents('.qe-line-item')
        unwantedLineItemEl$.removeClass('to-be-deleted')
    },

    // Delete selected line item from quote
    deleteQty(buttonEl) {
        const unwantedQtySectionEl$ = $(buttonEl).parents('.qe-qty-section')
        if (unwantedQtySectionEl$.hasClass('to-be-deleted')) {
            unwantedQtySectionEl$.remove()
        } else {
            unwantedQtySectionEl$.addClass('to-be-deleted')
        }
    },

    cancelDeleteQty(buttonEl) {
        const unwantedQtySectionEl$ = $(buttonEl).parents('.qe-qty-section')
        unwantedQtySectionEl$.removeClass('to-be-deleted')
    },

    // Called after a new product selected
    // Adds the html for the new item to the document, then calls updateLineItemEl to populate it
    buildNewLineItemEl(lineItemData) {
        const newLineItemEl$ = $(Quote.templateEditLineItem)
        Quote.lineItemDiv$.append(newLineItemEl$)
        Quote.initLineItemEvents(newLineItemEl$)
        Quote.updateLineItemEl(newLineItemEl$, lineItemData)
        Quote.addLoadedCustomValues(newLineItemEl$, lineItemData)
    },

    // Add any custom values
    // Called only on load
    addLoadedCustomValues(newLineItemEl$, lineItemData) {
        // Skip if there's nothing to do
        if (!lineItemData.customValues || lineItemData.customValues.length === 0) {
            return
        }

        // customValue looks like
        // { "qty": 10,
        //   "field": "unit_cost",
        //   "value": 20,
        //   "cost_id": 1674018127926
        // }
        for (const customValue of lineItemData.customValues || []) {
            const costRow = Quote.findLineItemQtyCostRow(newLineItemEl$, customValue.qty, customValue.cost_id)
            if (costRow) {
                let fieldClass = null
                switch (customValue.field) {
                    case 'unit_cost':
                        fieldClass = '.qe-component-unit-cost'
                        break
                    case 'unit_sell':
                        fieldClass = '.qe-component-unit-sell'
                        break
                    case 'fixed_cost':
                        fieldClass = '.qe-component-fixed-cost'
                        break
                    case 'setup_sell':
                        fieldClass = '.qe-component-setup-sell'
                        break
                    case 'freight_sell':
                        fieldClass = '.qe-component-freight-sell'
                        break
                    case 'freight_cost':
                        fieldClass = '.qe-component-freight-cost'
                        break
                }
                if (fieldClass) {
                    const costRow$ = $(costRow)
                    const inputEl$ = costRow$.find(fieldClass)
                    const calculatedValue = inputEl$.data('calculated-value')
                    inputEl$.data('custom-value', customValue.value)
                    inputEl$.addClass('custom-value')
                    inputEl$.prop('title', `Original value was ${Utils.currencyWithDollars(calculatedValue)}`)
                    inputEl$.val(Utils.currencyWithDollars(customValue.value, true))
                }
            }
        }
        // Need to recalc totals
        Quote.calcCostRowTotalsForLineItem(newLineItemEl$)
        Quote.calcQuoteSummaryTotals()
    },

    findLineItemQtyCostRow(lineItemEl$, qty, costId) {
        let costRow = null
        const qtySection = lineItemEl$.find('.qe-qty-section').toArray().find(qtySection => $(qtySection).data('qty') === qty)
        if (qtySection) {
            costRow = $(qtySection).find('.qe-cost-row').toArray().find(costRow => $(costRow).data('costId') === costId)
        }
        return costRow
    },

    // called after changes to a line item
    // re-sorts qty sections, hides/disables correct elements and recalculates everything
    lineItemCleanup(lineItemEl$) {
        // console.log('lineItemCleanup')
        Quote.sortQtySections(lineItemEl$)
        Quote.sortQtySections(lineItemEl$)
        Quote.enableDisableInputs(lineItemEl$)
        Quote.calcCostRowTotalsForLineItem(lineItemEl$)
        Quote.calcQuoteSummaryTotals()
    },

    // if there's changes to quantities (added or edited) they may now be in the wrong order
    sortQtySections(lineItemEl$) {
        const qtySectionEls = lineItemEl$.find('.qe-qty-section')
        // no point in sorting if there's nothing to sort
        if (qtySectionEls.length < 2)
            return

        // need to use detach to retain the jQuery data, events etc
        const qtySectionEl$s = lineItemEl$.find('.qe-qty-section').detach().toArray().map(el => $(el))
        qtySectionEl$s.sort((elA, elB) => elA.data('qty') - elB.data('qty'))
        lineItemEl$.find('.qe-qty-sections').append(qtySectionEl$s)
    },

    // Called in cleanup, after qtSections have been sorted
    enableDisableInputs(lineItemEl$) {
        const noCosts = (lineItemEl$.data('cost-components') || []).length === 0
        const qtySectionEls = lineItemEl$.find('.qe-qty-section')
        for (let qtyIndex = 0; qtyIndex < qtySectionEls.length; qtyIndex++) {
            const qtySectionEl$ = $(qtySectionEls[qtyIndex])
            // hide/show "no costs" row as needed
            noCosts
                ? qtySectionEl$.addClass('qe-section-no-prices')
                : qtySectionEl$.removeClass('qe-section-no-prices')
            // Only first set of decoration names are visible
            qtySectionEl$.find('.qe-component-name').prop('disabled', qtyIndex > 0)

            const costRows = qtySectionEl$.find('.qe-cost-row')
            for (let costIndex = 0; costIndex < costRows.length; costIndex++) {
                const costRow$ = $(costRows[costIndex])
                // console.log('component', costRow$.data('component'))
                // only show the qty for the first row
                costIndex > 0
                    ? costRow$.addClass('qe-cost-row-hide-qty')
                    : costRow$.removeClass('qe-cost-row-hide-qty')
            }
        }
    },

    calcCostRowTotalsForLineItem(lineItemEl$) {
        for (const qtySectionEl of lineItemEl$.find('.qe-qty-section').toArray()) {
            Quote.calcCostRowTotalsForQtySection($(qtySectionEl))
        }
    },

    calcCostRowTotalsForQtySection(qtySectionEl$) {
        for (const costRow of qtySectionEl$.find('.qe-cost-row').toArray()) {
            Quote.calcCostRowTotals($(costRow))
        }
        Quote.calcQtyTotalsForQtySection(qtySectionEl$)
    },

    calcCostRowTotals(costRow$) {
        // Fetch the elements
        const unitCostEl$ = costRow$.find('.qe-component-unit-cost')
        const unitSellEl$ = costRow$.find('.qe-component-unit-sell')
        const fixedCostEl$ = costRow$.find('.qe-component-fixed-cost')
        const setupSellEl$ = costRow$.find('.qe-component-setup-sell')
        const freightSellEl$ = costRow$.find('.qe-component-freight-sell')
        const freightCostEl$ = costRow$.find('.qe-component-freight-cost')

        let totals = costRow$.data('totals')
        let component = costRow$.data('component')

        const qty = totals.qty
        const unitCost = Quote.getCustomisableValue(unitCostEl$, QtyBreaks.costForQty(component.priceBreaks, qty))
        const markupPercent = parseFloat(costRow$.parents('.qe-qty-section').find('.qe-input-target-markup').val())
        const markupMultiplier = 1.0 + markupPercent / 100
        const unitSell = Quote.getCustomisableValue(unitSellEl$, Math.round((unitCost * markupMultiplier) * 100) / 100);
        const fixedCost = Quote.getCustomisableValue(fixedCostEl$, parseFloat(component.setup))

        let realSetupSell = 0
        let realFreightSell = 0
        let realFreightCost = 0
        if (component.isFreight) {
            realFreightCost = Math.round(fixedCost * 100) / 100;
            realFreightSell = Math.round((fixedCost * markupMultiplier) * 100) / 100;
        } else {
            realSetupSell = Math.round((fixedCost * markupMultiplier) * 100) / 100;

            const freightCost = Quote.getCustomisableValue(freightCostEl$, realFreightCost);
            realFreightSell = Math.round((freightCost * markupMultiplier) * 100) / 100;
        }

        const shownSetupSell = Quote.getCustomisableValue(setupSellEl$, realSetupSell)
        const shownFreightCost = Quote.getCustomisableValue(freightCostEl$, realFreightCost)
        const shownFreightSell = Quote.getCustomisableValue(freightSellEl$, realFreightSell)

        const lineCost = qty * unitCost + fixedCost + shownFreightCost
        const lineSell = qty * unitSell + shownFreightSell + shownSetupSell
        const lineProfit = lineSell - lineCost

        totals = {
            qty, unitCost, unitSell,
            markupPercent, markupMultiplier,
            fixedCost,
            realSetupSell, realFreightSell, realFreightCost, shownSetupSell, shownFreightSell, shownFreightCost,
            lineCost, lineSell, lineProfit
        }
        costRow$.data('totals', totals)

        Quote.setCustomisableValue(unitCostEl$, unitCost)
        Quote.setCustomisableValue(unitSellEl$, unitSell)
        Quote.setCustomisableValue(fixedCostEl$, fixedCost)
        Quote.setCustomisableValue(setupSellEl$, shownSetupSell)
        Quote.setCustomisableValue(freightSellEl$, shownFreightSell)
        Quote.setCustomisableValue(freightCostEl$, shownFreightCost)

        costRow$.find('.qe-component-line-cost').val(Utils.currencyWithDollars(lineCost, true))
        costRow$.find('.qe-component-line-profit').val(Utils.currencyWithDollars(lineProfit, true))
        costRow$.find('.qe-component-line-sell').val(Utils.currencyWithDollars(lineSell, true))
    },

    calcQtyTotalsForQtySection(qtySectionEl$) {
        let unitCost = 0
        let unitCostTimeQty = 0
        let fixedCost = 0
        let freightCost = 0
        let freightSell = 0
        let setupCost = 0
        let shownSetupSell = 0
        let shownFreightCost = 0
        let shownFreightSell = 0
        let lineCost = 0
        let lineProfit = 0
        let lineSell = 0
        let lineSellExFreightSell = 0
        let unitSell = 0
        let unitSellTimesQty = 0

        for (const costRow of qtySectionEl$.find('.qe-cost-row').toArray()) {
            let costTotals = $(costRow).data('totals')

            unitCost += costTotals.unitCost
            unitCostTimeQty += costTotals.unitCost * costTotals.qty
            fixedCost += costTotals.fixedCost
            setupCost += costTotals.fixedCost
            shownSetupSell += costTotals.shownSetupSell
            shownFreightCost += costTotals.shownFreightCost
            shownFreightSell += costTotals.shownFreightSell
            lineCost += costTotals.lineCost
            lineProfit += costTotals.lineProfit
            lineSell += costTotals.lineSell
            unitSell += costTotals.unitSell
            unitSellTimesQty += costTotals.unitSell * costTotals.qty
            lineSellExFreightSell += (costTotals.lineSell - costTotals.shownFreightSell)
        }

        const actualMarkupPercent = lineCost === 0 ? 0 : lineProfit / lineCost * 100
        const qtyTotals = {
            unitCost,
            unitCostTimeQty,
            fixedCost,
            unitSell,
            unitSellTimesQty,
            freightCost,
            freightSell,
            setupCost,
            shownSetupSell,
            shownFreightCost,
            shownFreightSell,
            lineCost,
            lineProfit,
            lineSell,
            lineSellExFreight: lineSellExFreightSell
        }
        qtySectionEl$.data('qtyTotals', qtyTotals)

        console.log('calcQtyTotalsForQtySection', qtyTotals);

        qtySectionEl$.find('.qe-qty-totals-actual-markup').val(Utils.percent1Decimal(actualMarkupPercent, false))
        qtySectionEl$.find('.qe-qty-totals-unit-sell').val(Utils.currencyWithDollars(unitSell, true))
        qtySectionEl$.find('.qe-qty-totals-setup').val(Utils.currencyWithDollars(shownSetupSell, true))
        qtySectionEl$.find('.qe-qty-totals-freight-cost').val(Utils.currencyWithDollars(shownFreightCost, true))
        qtySectionEl$.find('.qe-qty-totals-freight-sell').val(Utils.currencyWithDollars(shownFreightSell, true))
        qtySectionEl$.find('.qe-qty-totals-cost').val(Utils.currencyWithDollars(lineCost, true))
        qtySectionEl$.find('.qe-qty-totals-profit').val(Utils.currencyWithDollars(lineProfit, true))
        qtySectionEl$.find('.qe-qty-totals-sell').val(Utils.currencyWithDollars(lineSell, true))

        Quote.calcQuoteSummaryTotals()
    },

    // Called after all other totals calculated
    // NOTE: As per request from Kristian, sums together ALL totals, even if there's multiple qtys for an item
    // TODO: Get the correct GST data for each item
    //       At the moment assuming everything has GST
    // Name                     |  Calculation
    // -------------------------+----------------------------
    // Product & setup costs    |   2,368.00  |  Unit costs + Setup costs (ex)
    // Freight costs            |      16.67  |  Freight costs (ex)
    // Product & setup sell     |   3,055.00  |  Unit sell + Setup sell (ex)
    // Freight sell             |      25.00  |  Freight sell (ex)
    // GST                      |     308.00  |  (Unit sell ex + Setup sell ex + Freight sell ex) * 0.1
    // Total sell (inc)         |   3,388.00  |  Unit sell ex + Setup sell ex + Freight sell ex + GST
    // Profit $                 |     695.33  |
    // Profit %                 |      29.2%  |

    calcQuoteSummaryTotals() {
        let totalPartAndSetupCostEx = 0             // Unit costs + setups
        let totalFreightCostEx = 0
        let totalPartAndSetupSellEx = 0             // Unit costs + setups
        let totalFreightSellEx = 0
        let totalSellEx = 0                         // Total sell price - costs + setups + freight (ex)
        let totalGst = 0                    // GST to be added
        let totalSellInc = 0                // totalSellEx + gst
        let totalCostEx = 0 // Unit costs + Setups (ex)

        // let totalFreightSell = 0            // Freight shown sell (ex)
        let totalProfitEx = 0               // Total sell ex - total cost ex
        let totalMarkupPercent = 0          // Markup % -> Profit ex / Cost ex * 100

        for (const qtySectionEl of $('#quote-edit-line-items .qe-qty-section').toArray()) {
            const qtyTotals = $(qtySectionEl).data('qtyTotals')
            // qtyTotals fields:
            // unitCost, fixedCost, setupCost, freightCost, lineCost,
            // unitSell, shownSetupSell, shownFreightSell, lineSell,
            // lineProfit, lineSellExFreight
            if (qtyTotals) {
                totalPartAndSetupCostEx += qtyTotals.unitCostTimeQty + qtyTotals.setupCost
                totalFreightCostEx += qtyTotals.shownFreightCost
                totalPartAndSetupSellEx += qtyTotals.unitSellTimesQty + qtyTotals.shownSetupSell
                totalFreightSellEx += qtyTotals.shownFreightSell
                totalSellEx += qtyTotals.lineSell
                totalGst += qtyTotals.lineSell * 0.1

                console.log('qtyTotals', qtyTotals)
            }
        }
        totalSellInc = totalSellEx + totalGst
        totalCostEx = totalPartAndSetupCostEx + totalFreightCostEx
        totalProfitEx = totalSellEx - totalCostEx
        totalMarkupPercent = totalCostEx !== 0
            ? totalProfitEx / totalCostEx * 100
            : 0

        // Summary panel
        $('#qe-summary-part-and-setup-costs').text(Utils.currencyWithDollars(totalPartAndSetupCostEx, false))
        $('#qe-summary-freight-cost').text(Utils.currencyWithDollars(totalFreightCostEx, false))
        $('#qe-summary-part-and-setup-sell').text(Utils.currencyWithDollars(totalPartAndSetupSellEx, false))
        $('#qe-summary-freight-sell').text(Utils.currencyWithDollars(totalFreightSellEx, false))
        $('#qe-summary-gst').text(Utils.currencyWithDollars(totalGst, false))
        $('#qe-summary-total-inc').text(Utils.currencyWithDollars(totalSellInc, false))
        $('#qe-summary-profit').text(Utils.currencyWithDollars(totalProfitEx, false))
        $('#qe-summary-profit-markup').text(Utils.percent1Decimal(totalMarkupPercent, false))
        //
        // $('#total_part_amt').val(totalPartCostEx)
        // $('#freight').val(totalFreightSell)
        // $('#total_10_val').val(totalGst)
        // $('#total_w_tax_val').val(totalSellInc)
        // $('#profit_amt').val(totalProfitEx)
        // $('#cost_amt').val(totalPartCostAndFixedCostEx)
    },

    getCustomisableValue(inputEl$, defaultValue) {
        // There's some wonderful data coming through. Need to clean it up a bit
        // Remember - NaN is also a number. Yay javascript :)
        if (typeof (defaultValue) !== 'number' || isNaN(defaultValue)) {
            defaultValue = parseFloat(defaultValue)
            if (isNaN(defaultValue)) {
                defaultValue = 0
            }
        }
        // need to allow for the fact that custom value may be 0, which is falsy
        // so can't do this:  return inputEl$.data('custom-value') || defaultValue
        const customValue = inputEl$.data('custom-value')
        return typeof (customValue) == 'number' ? customValue : defaultValue
    },

    // Called when calculating row totals
    // Won't replace text is it's a custom value
    setCustomisableValue(inputEl$, newCalculatedValue) {
        inputEl$.data('calculated-value', newCalculatedValue)
        if (!inputEl$.data('custom-value')) {
            inputEl$.val(Utils.currencyWithDollars(newCalculatedValue, true))
        }
    },

    // Need to call this after a line item element is created
    // Initialises all the required events
    // The jQuery syntax used here -
    //    .on('blur', '.qe-qty-input', function(event){...})
    // means the events will also be applied to matching elements added dynamically in the future
    initLineItemEvents(newLineItemEl$) {
        // Update things when qty is changed
        newLineItemEl$.on('blur', '.qe-qty-input', function (event) {
            Quote.qtyBlur(newLineItemEl$, $(event.target))
        })

        // Event when user changes component name
        newLineItemEl$.on('blur', '.qe-component-name', function (event) {
            Quote.componentNameBlur(newLineItemEl$, $(event.target))
        })

        // Event when user changes margin
        newLineItemEl$.on('blur', '.qe-input-target-markup', function (event) {
            Quote.markupBlur(newLineItemEl$, $(event.target))
        })

        // Allow user to press enter in a field to update
        newLineItemEl$.on('keydown', 'input[type="text"]', function (event) {
            if ((event.keyCode || event.which) === 13) {
                event.target.blur()
            }
        })

        // Event when user enters/exits a customisable dollar field
        newLineItemEl$.on('focus', '.customizable-dollars', function (event) {
            Quote.customDollarsFocus($(event.target))
        })
        newLineItemEl$.on('blur', '.customizable-dollars', function (event) {
            Quote.customDollarsBlur($(event.target))
        })

        // Make delete items work
        newLineItemEl$.on('click', '.qe-delete', function (event) {
            // Delete is still buggy, so disabled for the moment
            Quote.deleteQtyCostRow(newLineItemEl$, $(event.target))
        })
        newLineItemEl$.on('click', '.qe-delete-cancel', function (event) {
            // Delete is still buggy, so disabled for the moment
            Quote.deleteQtyCostRowCancel(newLineItemEl$, $(event.target))
        })
    },

    // Makes sure a qty section exists for each qty
    buildQtySections(lineItemEl$, lineItemData) {
        const existingQtySectionEls = lineItemEl$.find('.qe-qty-section').toArray()
        const qtySectionsContainer$ = lineItemEl$.find('.qe-qty-sections')
        for (const qty of lineItemData.selectedQtys) {
            // Row may exist, if so, don't do anything
            let hasRow = false
            let newQtySectionEl$ = null
            for (const qtySectionEl of existingQtySectionEls) {
                if (parseInt($(qtySectionEl).data('qty')) === qty) {
                    // There's already a row for this qty
                    hasRow = true
                    break
                }
            }
            if (!hasRow) {
                // add row at end, lineItemCleanup will then sort these in the correct order
                newQtySectionEl$ = Quote.buildQtySection(qty, lineItemData)
                qtySectionsContainer$.append(newQtySectionEl$)
            }
            if (newQtySectionEl$) {
                // add any existing components to this qty
                // newly selected components (in componentsToAdd) will be added in the next step
                Quote.addCostComponentsToQtySection(newQtySectionEl$, lineItemData.costComponents)
            }
        }
    },

    buildQtySection(qty, lineItemData) {
        // console.log('buildQtySection', qty, lineItemData)
        let markup = null
        if (lineItemData.qtyData) {
            // console.log('lineItemData.qtyData', qty, lineItemData.qtyData)
            // console.log(lineItemData.qtyData.find(qd => qd.qty === qty))
            markup = lineItemData.qtyData.find(qd => qd.qty === qty).markup
        }
        // console.log('markup', markup)
        const qtySectionEl$ = $(Quote.templateEditLIQtySection)
        Quote.updateQtySectionQty(qtySectionEl$, qty, markup)

        return qtySectionEl$
    },

    // Called when qty changes
    // Also called to init new component rows after they've been added
    updateQtySectionQty(qtySectionEl$, newQty = null, markupPercent = null) {
        // console.log('updateQtySectionQty', newQty, markupPercent)
        if (newQty) {
            qtySectionEl$.data('qty', parseInt(newQty))
        } else {
            newQty = qtySectionEl$.data('qty')
        }
        qtySectionEl$.find('.qe-qty-input').val(newQty).data('current-qty', newQty)
        qtySectionEl$.find('.qe-qty-text').text(Utils.intWithThousands(newQty))
        if (markupPercent) {
            qtySectionEl$.find('.qe-input-target-markup').val(Utils.formatNumber(markupPercent, 1))
        }
        for (const costRow of qtySectionEl$.find('.qe-cost-row').toArray()) {
            let lineTotals = $(costRow).data('totals')
            if (lineTotals)
                lineTotals.qty = newQty
        }
        return qtySectionEl$
    },

    // Makes sure a cost price section exists for each price in each qty
    buildPriceSections(lineItemEl$, lineItemData) {
        if (lineItemData.componentsToAdd.length === 0)
            return

        for (const qtySectionEl of lineItemEl$.find('.qe-qty-section').toArray()) {
            Quote.addCostComponentsToQtySection($(qtySectionEl), lineItemData.componentsToAdd)
        }
    },

    buildComponentEl(newComponent, qty) {
        // console.log('buildComponentEl', newComponent.name, newComponent.costId)
        const newComponentEl$ = $(Quote.templateEditLIQtySectionRow)
        newComponentEl$.data('component', newComponent)
        newComponentEl$.data('cost-id', newComponent.costId)
        newComponentEl$.data('totals', { qty: qty })
        newComponentEl$.find('.qe-component-name').val(newComponent.name)
        // if it's freight, then by default don't show in "Price includes"
        // Need to check explicitly for false as priceIncludes may not exist
        if (newComponent.priceIncludes === false || newComponent.priceIncludes === undefined && newComponent.isFreight) {
            newComponentEl$.find('.qe-price-includes').prop('checked', false)
        }
        return newComponentEl$
    },

    addCostComponentsToQtySection(qtySectionEl$, costComponents) {
        const container$ = qtySectionEl$.find('.qe-qty-components')
        for (const newComponent of costComponents) {
            const newComponentEl$ = Quote.buildComponentEl(newComponent, qtySectionEl$.data('qty'))
            container$.append(newComponentEl$)
        }
        Quote.updateQtySectionQty(qtySectionEl$)
    },

    // Called when user exits qty. Changes the few references to qty for this section and recalculates everything
    qtyBlur(lineItemEl$, inputEl$) {
        // console.log('Qty exited', lineItemEl$, inputEl$)
        const newQty = parseInt(inputEl$.val())
        const qtySectionEl$ = inputEl$.parents('.qe-qty-section')
        Quote.updateQtySectionQty(qtySectionEl$, newQty)
        if (inputEl$.data('current-qty') !== newQty) {
            // console.log('qty changed', inputEl$.data('current-qty'), newQty)
        }
        Quote.lineItemCleanup(lineItemEl$)
    },

    componentNameBlur(lineItemEl$, inputEl$) {
        const costRow$ = inputEl$.parents('.qe-cost-row')
        // console.log('Name exited', costRow$.data('totals'))
        const component = costRow$.data('component')
        const oldName = component.originalName
        let newName = inputEl$.val().trim()
        if (newName.length === 0) {
            newName = component.originalName
        }
        if (newName !== component.name) {
            component.name = newName
            // only change names for lines with the same cost
            for (const otherCostRow$ of lineItemEl$.find('.qe-cost-row').toArray().map(el => $(el))) {
                const otherComponent = otherCostRow$.data('component')
                if (otherComponent === component) {
                    otherCostRow$.find('.qe-component-name').val(newName)
                }
            }
        }
    },

    markupBlur(lineItemEl$, inputEl$) {
        // console.log('Markup exited', lineItemEl$, inputEl$)
        // const newMarkup = parseFloat(inputEl$.val())
        // const qtySectionEl$ = inputEl$.parents('.qe-qty-section')
        // Quote.updateQtySectionQty(qtySectionEl$, newMarkup)
        // if (inputEl$.data('current-qty') !== newMarkup) {
        //     console.log('qty changed', inputEl$.data('current-qty'), newMarkup)
        // }
        Quote.lineItemCleanup(lineItemEl$)
    },

    customDollarsFocus(inputEl$) {
        const cleanValue = inputEl$.val().replace('$', '')
        inputEl$.val(cleanValue)
        inputEl$.data('value-on-enter', parseFloat(cleanValue))
        inputEl$.select()
    },

    customDollarsBlur(inputEl$) {
        // strip everything except numbers and periods
        const newValueText = inputEl$.val().replaceAll(/[^\d\.]/g, '')
        let newValueFloat = parseFloat(newValueText)
        // don't need to do anything if unchanged
        const valueOnEnter = inputEl$.data('value-on-enter')
        const valueChanged = newValueFloat !== valueOnEnter
        if (valueChanged) {
            const oldCustomValue = inputEl$.data('custom-value')
            const calculatedValue = inputEl$.data('calculated-value')
            // it's no longer a custom value if:
            // 1. value is blank
            // 2. It wasn't previously custom and the value is the same as the calculated value
            const isCustomValue = !(newValueText === '' || !oldCustomValue && newValueFloat === calculatedValue)
            // console.log({isCustomValue, newValueText, newValueFloat, calculatedValue, oldCustomValue})
            if (isCustomValue) {
                inputEl$.data('custom-value', newValueFloat)
                inputEl$.addClass('custom-value')
                inputEl$.prop('title', `Original value was ${Utils.currencyWithDollars(calculatedValue)}`)
            } else {
                inputEl$.data('custom-value', null)
                inputEl$.removeClass('custom-value')
                newValueFloat = calculatedValue
                inputEl$.removeProp('title')
            }
        }
        inputEl$.val(Utils.currencyWithDollars(newValueFloat, true))
        if (valueChanged) {
            Quote.calcCostRowTotalsForQtySection(inputEl$.parents('.qe-qty-section'))
        }
    },

    // cancels the delete action
    deleteQtyCostRowCancel(lineItemEl$, deleteEl$) {
        lineItemEl$.find('.qe-cost-row').removeClass('to-be-deleted')
        // const unwantedCostRow$ = deleteEl$.parents('.qe-cost-row')
        // unwantedCostRow$.removeClass('to-be-deleted')
    },

    deleteQtyCostRow(lineItemEl$, deleteEl$) {
        const unwantedCostRow$ = deleteEl$.parents('.qe-cost-row')
        const costId = unwantedCostRow$.data('cost-id')
        // 2 step process.
        // step 1 - just highlight the row and show the cancel button
        if (!unwantedCostRow$.hasClass('to-be-deleted')) {
            for (const costRowEl$ of lineItemEl$.find('.qe-cost-row').toArray().map(el => $(el))) {
                if (costRowEl$.data('cost-id') === costId) {
                    costRowEl$.addClass('to-be-deleted')
                }
            }
            return
        }
        // step 2 - they've pressed delete again, so this time delete
        const rowCostComponent = unwantedCostRow$.data('component')
        // remove the row elements from the html
        for (const costRow$ of lineItemEl$.find('.qe-cost-row').toArray().map(el => $(el))) {
            if (costRow$.data('cost-id') === costId) {
                costRow$.remove()
            }
        }
        // remove this cost from the list of costs
        const lineItemCostComponents = lineItemEl$.data('part-data').costComponents
        const componentIndex = lineItemCostComponents.indexOf(rowCostComponent)
        lineItemCostComponents.splice(componentIndex, 1)
        // cleanup
        Quote.enableDisableInputs(lineItemEl$)
        Quote.calcCostRowTotalsForLineItem(lineItemEl$)
    },

    // updates a lineItem's html with supplied details
    updateLineItemEl(lineItemEl$, lineItemData) {
        if (!lineItemData.costComponents) {
            lineItemData.costComponents = lineItemEl$.data('cost-components') || []
        }
        for (const cost of lineItemData.costComponents) {
            if (!cost.costId) {
                cost.costId = Utils.generateId()
            }
        }
        Quote.buildQtySections(lineItemEl$, lineItemData)
        Quote.buildPriceSections(lineItemEl$, lineItemData)
        // only overwrite the text inputs if line was not already here
        if (!lineItemEl$.data('part-id')) {
            lineItemEl$.data('part-id', lineItemData.part_id)
            lineItemEl$.data('quote-part-id', lineItemData.quote_part_id)
            lineItemEl$.find('.qe-supplier-code').text(lineItemData.code)
            lineItemEl$.find('.qe-item-name').val(lineItemData.name)
            lineItemEl$.find('.qe-item-description p').text(lineItemData.desc)
        }
        lineItemEl$.find('.qe-hero-image').attr('src', lineItemData.image)
        console.log('updateLineItemEl: lineItemData', lineItemData)
        // now we've created the elements, move the new components into the existing ones
        lineItemData.costComponents.push.apply(lineItemData.costComponents, lineItemData.componentsToAdd)
        lineItemData.componentsToAdd = []
        lineItemEl$.data('part-data', lineItemData)
        lineItemEl$.data('cost-components', lineItemData.costComponents)
        Quote.lineItemCleanup(lineItemEl$)
    },

    // Called when "Update quote" on product_overview_popup is clicked
    // Closes popup and also closes search modal if needed
    // Updates active line item with product data
    // Creates new line item if needed
    partDetailsSelected(part_id, sl) {
        // console.log('part selected', part_id)
        const selectedPartData = Quote.extractProductDataFromForm()
        $('#product-overview-popup').modal('hide')
        $('#partapi_modal_form').modal('hide')

        console.log('partDetailsSelected: selectedPartData', selectedPartData)
        if (Quote.activeLineItem$) {
            Quote.updateLineItemEl(Quote.activeLineItem$, selectedPartData)
        } else {
            Quote.buildNewLineItemEl(selectedPartData)
        }
    },

    // Called by partDetailsSelected after product_overview_popup is closed
    // takes the relevant data and returns it in manageable format; as an object
    extractProductDataFromForm() {
        const partPopup$ = $('#part-popup-details')
        const imageRadio$ = partPopup$.find('.product-overview-images input[type="radio"]:checked')
        const imageSrc = imageRadio$.parent().find('img').attr('src')

        return {
            part_id: partPopup$.data('part-id'),
            code: partPopup$.data('part-code'),
            name: partPopup$.data('part-name'),
            desc: partPopup$.data('part-desc'),
            image: imageSrc,
            selectedQtys: QtyBreaks.popupSelectedQtys(partPopup$),
            componentsToAdd: QtyBreaks.popupSelectedPrices(partPopup$)
        }
    },

    // Shows the modal that allows users to search for products
    // On first display need to initialise supplier select and form
    // showPartSearchDialog(callback) {
    //     $('#partapi_modal_form').modal('show')
    //     if (!Quote.searchModalLoaded) {
    //         $('#part-search-form').submit((event) => {
    //             event.preventDefault()
    //             const supplierIds = $('#parts-supplier-list').val()
    //             const searchTerm = $('#parts-search-term').val()
    //             // console.log(newItemsChecked)
    //             // console.log(categoryId);
    //             Quote.searchForParts(searchTerm,0, supplierIds)
    //         })
    //     }
    // },
    showPartSearchDialog(callback) {
        $('#partapi_modal_form').modal('show')
        if (!Quote.searchModalLoaded) {
            $('#part-search-form').submit((event) => {
                event.preventDefault()

                const supplierIds = $('#parts-supplier-list').val()
                const searchTerm = $('#parts-search-term').val()
                const minValue = $('#min-price').val()
                const maxValue = $('#max-price').val()
                const categoryId=$('#parts_part_category_filter').val()
                //Strange right, it is not working with boolean variable but perfectly working with 1 and 0.
                const newItemsChecked = $('#new_items').is(':checked')
                const itemWithImages = $('#item_with_image').is(':checked')
                const showDiscontinued = $('#show_discontinued').is(':checked')
                // const dataSource = $('input[name="data_source"]:checked').val(); // Get selected radio button value
                const dataSource = $('input[name="data_source"]:checked').map(function () {
                    return $(this).val();
                }).get(); // Returns an array of selected values

                let errorMessages = []

                // Check for missing values and add error messages to the array
                if (!searchTerm) {
                    errorMessages.push('Search term is required.')
                }

                if (minValue) {
                    // If min value is provided, max value is also required
                    if (!maxValue) {
                        errorMessages.push('Maximum price is required if minimum price is provided.')
                    }
                }

                // If there are any errors, display them and stop the form submission
                if (errorMessages.length > 0) {
                    alert(errorMessages.join('\n'))
                    return
                }

                // console.log(categoryId);
                Quote.searchForParts(searchTerm, minValue, maxValue, categoryId ,newItemsChecked,itemWithImages,0, supplierIds,dataSource, showDiscontinued)
            })
        }
    },

    // Load next page of results and append them to existing ones
    // loadMoreSearchResults(nextPageIndex) {
    //     const supplierIds = $('#parts-supplier-list').val()
    //     const searchTerm = $('#parts-search-term').val()
        

    //     Quote.searchForParts(searchTerm,nextPageIndex, supplierIds)
    // },
    loadMoreSearchResults(nextPageIndex) {
        const supplierIds = $('#parts-supplier-list').val()
        const searchTerm = $('#parts-search-term').val()
        const minValue = $('#min-price').val()
        const maxValue = $('#max-price').val()
        const categoryId=$('#parts_part_category_filter').val()
        const newItemsChecked = $('#new_items').is(':checked')
        const itemWithImages = $('#item_with_image').is(':checked')
        const showDiscontinued = $('#show_discontinued').is(':checked')

        // const dataSource = $('input[name="data_source"]:checked').val(); // Get selected radio button value
        const dataSource = $('input[name="data_source"]:checked').map(function () {
            return $(this).val();
        }).get(); // Returns an array of selected values

        Quote.searchForParts(searchTerm, minValue, maxValue,categoryId, newItemsChecked,itemWithImages,nextPageIndex, supplierIds,dataSource, showDiscontinued)
    },


    // Called after initial display and also each lot of search results
    // re-applies jQuery events and also inits the supplier selection element
    displayProductSearchResults(resultsHtml, pageIndex) {
        const resultsHtml$ = $(resultsHtml)
        const loadMoreEl$ = resultsHtml$.find('#load-more-panel')
        const productGridEl$ = resultsHtml$.find('#product-search-results')
        const searchFormEl$ = $('.partapi-modal-form-content')
        searchFormEl$.find('#load-more-panel').replaceWith(loadMoreEl$)
        if (pageIndex === 0) {
            // If it's page 0, then we're replacing existing contents
            searchFormEl$.find('#product-search-results').replaceWith(productGridEl$)
        } else {
            // if not, we need to append to the current results
            searchFormEl$.find('#product-search-results').append(productGridEl$.find('.product-search-card'))
        }
    },

    // Called from the part search modal
    // Queries server then updates modal with results
    // searchForParts(search_term = null,page = 0, supplier_ids = 'all') {
    //     if (!supplier_ids || supplier_ids.length === 0) {
    //         supplier_ids = 'all'
    //     }
    //     let path = window.SSR.routes["quotes:search_for_part"] + '/'
    //     if (search_term) {
    //         path += [encodeURIComponent(search_term), page, supplier_ids].join('/')
    //     }
    //     $("#pageloader").fadeIn()
    //     $.ajax({
    //         type: "GET", url: path,
    //         success: function (resultsHtml) {
    //             $('#partapi_modal_form').modal('show')
    //             $("#pageloader").fadeOut()
    //             Quote.displayProductSearchResults(resultsHtml, page)
    //         }
    //     })
    // },
    searchForParts(search_term, minValue, maxValue, categoryIds = [], newItemsChecked = false, itemWithImages = true, page = 0, supplierIds = [], dataSource = [], showDiscontinued = false) {
        // Prepare form data with proper defaults and validation
        const formData = {
            search_term: search_term || '',
            min_price: minValue.length > 0 ? minValue : undefined,
            max_price: maxValue.length > 0 ? maxValue : undefined,
            category_ids: Array.isArray(categoryIds) ? categoryIds : [],
            new_items: newItemsChecked === true,
            item_with_image: itemWithImages === true,
            show_discontinued: showDiscontinued === true,
            page: page || 0,
            supplier_ids: Array.isArray(supplierIds) && supplierIds.length > 0 ? supplierIds : [],
            data_source: Array.isArray(dataSource) && dataSource.length > 0 ? dataSource : ['0', '1']
        };

        $("#pageloader").fadeIn();
        $.ajax({
            type: "POST",
            url: window.SSR.routes["quotes:search_for_part"],
            data: formData,
            success: function (resultsHtml) {
                $('#partapi_modal_form').modal('show');
                $("#pageloader").fadeOut();
                Quote.displayProductSearchResults(resultsHtml, page);
            }
        });
    },

    // Called when a product is selected from the product search modal
    // or when an existing line item is altered
    // Shows product_overview_popup
    showProductOverview(popupId, partId) {
        $("#pageloader").fadeIn();
        $.post(window.SSR.routes['quotes:get_part_popup'], {
            'part_id': partId,
            'popup_id': popupId
        }, function (result) {
            //console.log(result);
            $(".popupData").html(result);
            Quote.selectCorrectOverviewOptions()
            $('#product-overview-popup').modal('show');
            $("#pageloader").fadeOut();
        })
    },

    // Called after product overview loaded
    // Need to preset selected image, qtys, prices etc so they don't get reset if user clicks "update quote"
    selectCorrectOverviewOptions() {
        if (Quote.activeLineItem$) {
            const lineItemData = Quote.activeLineItem$.data('part-data')
            const popupEl$ = $('#product-overview-popup')
            for (const imageEl of popupEl$.find('.product-overview-images img').toArray()) {
                // images are inside aa label, below the radio button
                // <label>
                //     <input type="radio" name="images" class="jschecked" id="img4" value="https://res.cloudinary.com/promodata/trends/118087-4.jpg" selected="selected">
                //     <img src="https://res.cloudinary.com/promodata/trends/118087-4.jpg" class="iconDetails img-responsive">
                // </label>
                if (imageEl.src === lineItemData.image) {
                    $(imageEl.parentNode).find('input').prop('checked', true)
                }
            }
        }
        QtyBreaks.initOverviewQtySelector(Quote.activeLineItem$)
        QtyBreaks.initOverviewPriceSelector(Quote.activeLineItem$)
    },

    // Called when "Change details" on an existing line item is clicked
    changeLineItemDetails(buttonEl) {
        Quote.activeLineItem$ = $(buttonEl).parents('.qe-line-item')
        const partId = Quote.activeLineItem$.data('part-id')
        // console.log('changeLineItemDetails', partId)
        Quote.showProductOverview(0, partId)
    },

    // Show the "edit description" modal
    showEditDescriptionModal(buttonEl) {
        Quote.activeLineItem$ = $(buttonEl).parents('.qe-line-item')
        const partId = Quote.activeLineItem$.data('part-id')

        $("#pageloader").fadeIn();
        $.post(window.SSR.routes['quotes:get_description_popup'], {
            'part_id': partId
        }, function (result) {
            $(".previewQuoteDiv").html(result);
            $('#preview_quote_modal').modal('show');
            $("#pageloader").fadeOut();
        })
    },

    // Edit the description of a line item
    updateDescription() {
        const description = $('#descriptionText').val()
        Quote.activeLineItem$.find('.qe-item-description p').text(description)
        $('#preview_quote_modal').modal('hide')
    }
}

QtyBreaks = {
    // Called after we get the html for the part overview popup
    // Inserts all the current selected options for current line item
    initOverviewQtySelector(lineItemEl$) {
        const partPopup$ = $('#part-popup-details')
        const defaultQtys = JSON.parse(partPopup$.find('.overview-default-qtys').val() || '[]')
        const selectedQtys = QtyBreaks.extractQtysFromLineItemEl(lineItemEl$)
        QtyBreaks.buildQtyList(partPopup$, defaultQtys, selectedQtys)
    },

    // Called after we get the html for the part overview popup
    // Inserts all the current selected options for current line item
    // and inits jQuery events for the price checkboxes
    initOverviewPriceSelector(lineItemEl$) {
        const partPopup$ = $('#part-popup-details')
        partPopup$.find('.price-set-row input[type="checkbox"]').change((event) => {
            // console.log('checkbox checked', event.target)
            const checkboxEl$ = $(event.target)
            const priceSelected = event.target.checked
            const priceRow$ = checkboxEl$.parents('.price-set-row')
            if (priceSelected)
                priceRow$.addClass('selected')
            else
                priceRow$.removeClass('selected')
            // if selected, then select parent too
            // Don't unselect children if parent unselected as they may be adding just the child
            if (priceSelected && priceRow$.hasClass('price-set-addition')) {
                // select parent price
                const parentRow$ = checkboxEl$.parents('.price-set').find('.price-set-base')
                parentRow$.find('input[type="checkbox"]').prop('checked', true)
                parentRow$.addClass('selected')
            }
        })
    },

    // Get the current qtys for this line item
    // lineItemEl$ may not exist if we're adding a new item
    extractQtysFromLineItemEl(lineItemEl$) {
        if (lineItemEl$) {
            const qtySectionEls = lineItemEl$.find('.qe-qty-section').toArray()
            return qtySectionEls.map(qtySectionEl => $(qtySectionEl).data('qty'))
        } else {
            return []
        }
    },

    // Combine defaultQtys and selectedQtys into a single unique list
    // Build the html for these qty buttons and insert into the popup
    buildQtyList(partPopup$, defaultQtys, selectedQtys) {
        const allQtys = Utils.uniqueSortedList(defaultQtys.concat(selectedQtys))
        const container$ = partPopup$.find('.overview-selected-qtys')
        container$.html('')
        for (const qty of allQtys) {
            const selected = selectedQtys.indexOf(qty) > -1
            const inputId = `qty-btn-${qty}`
            container$.append(`<input type="checkbox" class="btn-check" value="${qty}" ${selected ? 'checked="checked"' : ''} id="${inputId}" autocomplete="off">`)
            container$.append(`<label class="btn btn-outline-secondary ${selected ? 'active' : ''}" for="${inputId}">${qty}</label>`)
        }
    },

    // Called after user enters a custom qty
    // Adds it to the list and selects it
    addCustomQty() {
        const partPopup$ = $('#part-popup-details')
        const qtyInput$ = partPopup$.find('.select-qty-row .custom-qty')
        const newQty = parseInt(qtyInput$.val())
        // console.log('Adding new qty 1', newQty)
        if (newQty > 0) {
            const selectedQtys = QtyBreaks.popupSelectedQtys(partPopup$)
            // console.log('Adding new qty 2', selectedQtys)
            selectedQtys.push(newQty)
            // Doesn't matter if new qty exists, buildQtyList will sort that
            // console.log('Adding new qty 3', QtyBreaks.popupAvailableQtys(partPopup$))
            QtyBreaks.buildQtyList(partPopup$, QtyBreaks.popupAvailableQtys(partPopup$), selectedQtys)
            qtyInput$.val('')
            qtyInput$.focus()
        }
    },

    popupSelectedQtys(partPopup$) {
        const selectedQtyEls = partPopup$.find('.overview-selected-qtys input[type="checkbox"]:checked').toArray()
        return selectedQtyEls.map(el => parseInt(el.value))
    },
    popupAvailableQtys(partPopup$) {
        const availableQtyEls = partPopup$.find('.overview-selected-qtys input[type="checkbox"]').toArray()
        return availableQtyEls.map(el => parseInt(el.value))
    },

    customQtyKeyDown(event) {
        if ((event.keyCode || event.which) === 13) {
            event.preventDefault()
            QtyBreaks.addCustomQty()
        }
    },

    popupSelectedPrices(partPopup$) {
        return partPopup$.find('.price-set-row.selected').toArray().map((rowEl) => {
            const rowEl$ = $(rowEl)
            // console.log('selected item is freight ', rowEl$.data('is-freight'))
            const fullName = rowEl$.data('name')
            const displayName = fullName.split("|").pop()
            return {
                costId: Utils.generateId(),
                fullName: fullName,
                name: displayName,
                originalName: displayName,
                code: rowEl$.data('code'),
                supplier: rowEl$.data('supplier'),
                supplierId: rowEl$.data('supplier-id'),
                partId: rowEl$.data('part-id'),
                setup: rowEl$.data('setup'),
                isFreight: !!rowEl$.data('is-freight'),  // php sends through true as 1, false as an empty string
                priceBreaks: (rowEl$.data('price-breaks') || []),
            }
        })
    },

    costForQty(priceBreaks, qty) {
        if (Utils.isBlank(priceBreaks))
            return 0
        if (qty < priceBreaks[0].qty)
            // less than min qty
            return priceBreaks[0].price
        let lastBreak = null
        for (let priceBreak of priceBreaks) {
            // Some data has the values as strings, which, yay, js "adds" later on by concatenating
            priceBreak.qty = parseInt(priceBreak.qty)
            priceBreak.price = parseFloat(priceBreak.price)
            if (priceBreak.qty > qty) {
                if (lastBreak)
                    return lastBreak.price
                else
                    return priceBreaks[0].price
            }
            lastBreak = priceBreak
        }
        return lastBreak.price
    },

}

window.Quote = Quote
window.QtyBreaks = QtyBreaks

