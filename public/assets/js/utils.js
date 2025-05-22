uniqueList = (list, key = null) => {
    return key ? [... new Set(list.map(item => item[key]))] : [... new Set(list)]
}
// For sorting arrays of numbers
uniqueSortedList = (list) => {
    return this.uniqueList(list).sort((a, b) => a - b)
}
currencyNoDollars = (number) => {
    // number may be a string or null
    return formatNumber(number, 2)
}
currencyWithDollars = (number, blankIfZero = false, hideCents = false, blankText = '-') => {
    if (blankIfZero && Math.abs(number) < 0.000001)
        return blankText
    return formatNumber(number, hideCents ? 0 : 2, '$')
}
intWithThousands = (number) => {
    return formatNumber(number, 0)
}
percent1Decimal = (number, blankIfZero = false) => {
    if (blankIfZero && Math.abs(number) < 0.000001)
        return ''
    return formatNumber(number, 1, '', '%')
}
formatNumber = (number, decimalPlaces = 0, prefix = '', suffix = '') => {
    // number may be a string or null
    // prefix eg $
    // suffix eg %
    let numberText = null
    if (Math.abs(number) === Infinity) {
        numberText = '-'
    } else {
        const numberFloat = parseFloat(number || '0')
        const numberParts = numberFloat.toFixed(decimalPlaces).split('.')
        numberText = parseInt(numberParts[0]).toLocaleString()
        if (decimalPlaces > 0) {
            numberText += '.' + numberParts[1]
        }
    }
    return prefix + numberText + suffix
}

defaultText = (someValue, textIfNull) => {
    return (someValue === null || typeof(someValue) === 'undefined') ? textIfNull : someValue
}
toText = (someValue) => {
    return defaultText(someValue, '').toString().trim()
}
toWords = (underscoredString) => {
    return defaultText(underscoredString, '').replaceAll(/[_-]/g,' ')
}
isBlank = (someValue) => {
    if (someValue === null)
        return true
    else if (Array.isArray(someValue))
        return someValue.reduce(((t, n) => t && isBlank(n)), true)
    else
        return toText(someValue).length === 0
}
isBlankOrZero = (someValue) => {
    return someValue === 0 || isBlank(someValue)
}
isNotBlank = (someValue) => {
    return !isBlank(someValue)
}
isValidNumber = (numberOrText) => {
    if (isBlank(numberOrText)) {
        return false
    }
    return isFinite(numberOrText)
}
isPositiveInt = (numberOrText) => {
    if (isBlank(numberOrText)) {
        return false
    }
    const intNumber = parseInt(numberOrText)
    return (numberOrText.toString().trim() === intNumber.toString()) && (intNumber > 0)
}
removeBlanks = (someArray) => {
    return someArray.filter(item => !isBlank(item))
}
mapReduce = (someArray, propertyName) => {
    return someArray.map(item => item[propertyName]).reduce((a, b) => a + b)
}
generateId = () => {
    if (Date.now() - Utils.nextId > 1000) {
        Utils.nextId = Date.now()
    }
    return Utils.nextId++
}


window.Utils = {
    nextId: 1,
    currencyNoDollars,
    currencyWithDollars,
    defaultText,
    formatNumber,
    generateId,
    intWithThousands,
    isBlank,
    isBlankOrZero,
    isNotBlank,
    isPositiveInt,
    isValidNumber,
    mapReduce,
    percent1Decimal,
    removeBlanks,
    toText,
    toWords,
    uniqueList,
    uniqueSortedList,
}
