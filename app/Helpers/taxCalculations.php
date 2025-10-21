<?php

if (! function_exists('calculateHealthInsurance')) {
	function calculateHealthInsurance($yearlyRevenue, $monthlyTaxBase) 
	{
		// Scale
		$onScaleHealthInsurance = $monthlyTaxBase * 0.09;
		if ($onScaleHealthInsurance < 314.96) $onScaleHealthInsurance = 314.96;
		// Flat
		$onFlatHealthInsurance = $monthlyTaxBase * 0.049;
		if ($onFlatHealthInsurance < 314.96) $onFlatHealthInsurance = 314.96;
		// Lump-sum
		$onLumpSumHealthInsurance = null;
		if ($yearlyRevenue <= 60000) {
			$onLumpSumHealthInsurance = 461.66;
		} elseif ($yearlyRevenue <= 300000) {
			$onLumpSumHealthInsurance = 769.43;
		} else {
			$onLumpSumHealthInsurance = 1384.97;
		}
		// Return yearly rates
		return [
			'scale' => $onScaleHealthInsurance * 12,
			'flat' => $onFlatHealthInsurance * 12,
			'lump-sum' => $onLumpSumHealthInsurance * 12
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

		$monthlyTaxBase = $monthlyRevenue - $monthlyExpense - $zusRate[$zus];
		$yearlyTaxBase = $monthlyTaxBase * 12;

		// Health insurance
		$healthInsurance = calculateHealthInsurance($monthlyRevenue * 12, $monthlyTaxBase);
		// Flat tax
		$yearlyFlatTax = $yearlyTaxBase * 0.19;
		// Scale tax
		$yearlyScaleTax = 0;
		if ($yearlyTaxBase > 30000 && $yearlyTaxBase <= 120000) {
			$yearlyScaleTax = ($yearlyTaxBase * 0.12) - 3600;
		} elseif ($yearlyTaxBase > 120000) {
			$yearlyScaleTax =  10800 + (($yearlyTaxBase - 120000) * 0.32);
		}
		// Lump-sum tax
		$yearlyLumpSumIncome = (($monthlyRevenue - $zusRate[$zus]) * 12) - $healthInsurance['lump-sum'] * 0.5;
		$yearlyLumpSumTax = ($yearlyLumpSumIncome * ($lumpSumRate / 100));

		$taxes = [
			'scale' => [
				'zus' => $zusRate[$zus] * 12,
				'healthInsurance' => $healthInsurance['scale'],
				'tax' => $yearlyScaleTax,
				'income' => $yearlyTaxBase - $yearlyScaleTax - $healthInsurance['scale']
			],
			'flat' => [
				'zus' => $zusRate[$zus] * 12,
				'healthInsurance' => $healthInsurance['flat'],
				'tax' => $yearlyFlatTax,
				'income' => $yearlyTaxBase - $yearlyFlatTax - $healthInsurance['flat']
			],
			'lump-sum' => [
				'zus' => $zusRate[$zus] * 12,
				'healthInsurance' => $healthInsurance['lump-sum'],
				'tax' => $yearlyLumpSumTax,
				'income' => (($monthlyRevenue - $zusRate[$zus]) * 12) - $yearlyLumpSumTax - $healthInsurance['lump-sum']
			]
		];
		
		return $taxes;
    }
}