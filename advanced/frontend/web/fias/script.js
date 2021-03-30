$(function () {
	var $address_passport = $('[name="RegisterForm[address_passport_street]"]'),
	    $address_current = $('[name="RegisterForm[address_current_street]"]'),
		$building_passport = $('[name="RegisterForm[address_passport_building]"]'),
		$building_current = $('[name="RegisterForm[address_current_building]"]');

	$address_passport.fias({
		oneString: true,
		verify: true
		// change: function (obj) {
		// 	console.log(obj.id);
		// }
	});

	$address_current.fias({
		oneString: true,
		verify: true
	});


	$building_passport.fias({
		type: $.fias.type.building,
		parentInput: $address_passport,
		verify: true
	});

	$building_current.fias({
		type: $.fias.type.building,
		parentInput: $address_current,
		verify: true
	});


});
