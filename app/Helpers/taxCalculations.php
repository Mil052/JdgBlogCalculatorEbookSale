<?php

if (! function_exists('calculateScaleTaxOutcome')) {
    function calculateScaleTaxOutcome ($monthlyRevenue, $monthlyExpense, $zusRate)
	{
		$monthlyTaxBase = $monthlyRevenue - $monthlyExpense - $zusRate;
		// Health insurance
		$monthlyHealthInsurance = $monthlyTaxBase * 0.09;
		if ($monthlyHealthInsurance < 314.96) $monthlyHealthInsurance = 314.96;
		$healthInsurance = $monthlyHealthInsurance * 12;
		// Tax
		$yearlyTaxBase = $monthlyTaxBase * 12;
		$yearlyTax = 0;
		if ($yearlyTaxBase > 30000 && $yearlyTaxBase <= 120000) {
			$yearlyTax = ($yearlyTaxBase * 0.12) - 3600;
		} elseif ($yearlyTaxBase > 120000) {
			$yearlyTax =  10800 + (($yearlyTaxBase - 120000) * 0.32);
		}

		return [
			'zus' => $zusRate * 12,
			'healthInsurance' => $healthInsurance,
			'tax' => $yearlyTax,
			'income' => $yearlyTaxBase - $yearlyTax - $healthInsurance
		];
	}
}

if (! function_exists('calculateFlatTaxOutcome')) {
    function calculateFlatTaxOutcome ($monthlyRevenue, $monthlyExpense, $zusRate)
	{
		$monthlyTaxBase = $monthlyRevenue - $monthlyExpense - $zusRate;
		$yearlyTaxBase = $monthlyTaxBase * 12;
		// Health insurance
		$monthlyHealthInsurance = $monthlyTaxBase * 0.049;
		if ($monthlyHealthInsurance < 314.96) $monthlyHealthInsurance = 314.96;
		$healthInsurance = $monthlyHealthInsurance * 12;
		// Tax
		$yearlyTax = $yearlyTaxBase * 0.19;

		return [
			'zus' => $zusRate * 12,
			'healthInsurance' => $healthInsurance,
			'tax' => $yearlyTax,
			'income' => $yearlyTaxBase - $yearlyTax - $healthInsurance
		];
	}
}

if (! function_exists('calculateLumpSumTaxOutcome')) {
    function calculateLumpSumTaxOutcome ($monthlyRevenue, $monthlyExpense, $zusRate, $lumpSumRate)
	{
		$yearlyRevenue = $monthlyRevenue * 12;
		// Health insurance
		$monthlyHealthInsurance = null;
		if ($yearlyRevenue <= 60000) {
			$monthlyHealthInsurance = 461.66;
		} elseif ($yearlyRevenue <= 300000) {
			$monthlyHealthInsurance = 769.43;
		} else {
			$monthlyHealthInsurance = 1384.97;
		}
		$healthInsurance = $monthlyHealthInsurance * 12;
		// Lump-sum tax
		$yearlyLumpSumIncome = (($monthlyRevenue - $zusRate) * 12) - ($healthInsurance * 0.5);
		$yearlyTax = ($yearlyLumpSumIncome * $lumpSumRate / 100);

		return [
			'zus' => $zusRate * 12,
			'healthInsurance' => $healthInsurance,
			'tax' => $yearlyTax,
			'income' => (($monthlyRevenue - $monthlyExpense - $zusRate) * 12) - $yearlyTax - $healthInsurance
		];
	}
}

if (! function_exists('calculateTaxes')) {
    function calculateTaxes($monthlyRevenue, $monthlyExpense, $zus, $lumpSumRate) 
    {
		$zusRate = [
			'start-relief' => 0,
			'reduced' => 477.20,
			'full' => 1774.06
		];
		
		$taxes = [
			'scale' => calculateScaleTaxOutcome(
				$monthlyRevenue,
				$monthlyExpense,
				$zusRate[$zus]
			),
			'flat' => calculateFlatTaxOutcome(
				$monthlyRevenue,
				$monthlyExpense,
				$zusRate[$zus]
			),
			'lump-sum' => calculateLumpSumTaxOutcome(
				$monthlyRevenue,
				$monthlyExpense,
				$zusRate[$zus],
				$lumpSumRate
			)
		];
		
		return $taxes;
    }
}