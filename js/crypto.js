
// You can define your own formats in order to be compatible with other crypto implementations.
// A format is an object with two methods —stringify and parse— that converts between CipherParams objects and ciphertext strings.
// Based on https://code.google.com/archive/p/crypto-js/
var CryptoJSFormatter = {
	stringify: function (cipherParams) {
		// create json object with ciphertext
		var jsonObj = { ct: cipherParams.ciphertext.toString(CryptoJS.enc.Base64) };

		// optionally add iv and salt
		if (cipherParams.iv) {
			jsonObj.iv = cipherParams.iv.toString();
		}
		if (cipherParams.salt) {
			jsonObj.s = cipherParams.salt.toString();
		}

		// stringify json object
		return JSON.stringify(jsonObj);
	},
	parse: function (jsonStr) {
		// parse json string
		var jsonObj = JSON.parse(jsonStr);

		// extract ciphertext from json object, and create cipher params object
		var cipherParams = CryptoJS.lib.CipherParams.create({ ciphertext: CryptoJS.enc.Base64.parse(jsonObj.ct) });

		// optionally extract iv and salt
		if (jsonObj.iv) {
			cipherParams.iv = CryptoJS.enc.Hex.parse(jsonObj.iv)
		}
		if (jsonObj.s) {
			cipherParams.salt = CryptoJS.enc.Hex.parse(jsonObj.s)
		}
		return cipherParams;
	}
};

// PHP -> JS: text
var decryptedPhp1 = CryptoJS.AES.decrypt(encryptedData1, '0123456789abcdef0123456789abcdef', {format: CryptoJSFormatter})
	.toString(CryptoJS.enc.Utf8);
console.log('encrypted = ' + encryptedData1);
console.log('decrypted - PHP = ' + decryptedPhp1);
var elemPlaceholder = document.getElementById('js-decrypted-text');
elemPlaceholder.innerText = decryptedPhp1;


// PHP -> JS: json
var decryptedPhp2 = CryptoJS.AES.decrypt(encryptedData2, '0123456789abcdef0123456789abcdef', {format: CryptoJSFormatter})
	.toString(CryptoJS.enc.Utf8);
console.log('decrypted PHP JSON = ' + decryptedPhp2);
var elemPlaceholder2 = document.getElementById('js-decrypted-json');
elemPlaceholder2.innerText = decryptedPhp2;


//  JS end to end - encryption and decryption
//var encrypted = CryptoJS.AES.encrypt("Message", "0123456789abcdef0123456789abcdef", { format: CryptoJSFormatter });
//console.log(encrypted);
//var decryptedJS = CryptoJS.AES.decrypt(encrypted,
//	'0123456789abcdef0123456789abcdef',
//	{format: CryptoJSFormatter}
//).toString(CryptoJS.enc.Utf8);
//console.log('decrypted JS = ' + decryptedJS);