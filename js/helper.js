function numbersonly(myfield, e, dec) {
	var key;
	var keychar;
	
	if (window.event)
		key = window.event.keyCode;
	else if (e)
		key = e.which;
	else
		return true;
	
	keychar = String.fromCharCode(key);
	
	// control keys
	if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) )
		return true;
	// numbers
	else if ((("0123456789").indexOf(keychar) > -1))
		return true;
	// decimal point jump
	else if (dec && (keychar == ".")) {
		myfield.form.elements[dec].focus();
		return false;
	}
	else
		return false;
}


function titikribuan(textInput){
    //
    var addRupiah;
    if (textInput.value.substr(0,3) == 'Rp ') {
	addRupiah = 'Rp ';
	angka = textInput.value.substr(3);
    } else {
	addRupiah = '';
	angka = textInput.value;
    }
    for(g=angka.length; g>0; g--){
	//hilangkan semua titik terlebih dahulu
	angka = angka.replace('.','');
    }
    
    hasil_akhir = "";
    jumlah_angka = 0;
    for (g=angka.length; g>0; g--){
	jumlah_angka++;
	if (((jumlah_angka % 3) == 1) && (jumlah_angka != 1)){
	    hasil_akhir = angka.substr(g-1,1) + "." + hasil_akhir;
	} else {
	    hasil_akhir = angka.substr(g-1,1) + hasil_akhir;
	}
    }
    textInput.value = addRupiah+hasil_akhir;
}
