/**
 * CryptoJS Helper to prep server data and return decrypted data
 * @type {{init, decrypt}}
 */
var cryptoHelper = (function(CryptoJS) {
	var init = function() {

	};

	var decrypt = function(encryptedJson, passphrase) {
		try {
			var encrypted = encryptedJson.cipherText;
			var salt = CryptoJS.enc.Hex.parse(encryptedJson.salt);
			var iv = CryptoJS.enc.Hex.parse(encryptedJson.iv);
			var iterations = Number(atob(encryptedJson.iter));

			var key = CryptoJS.PBKDF2(passphrase, salt, {
				hasher: CryptoJS.algo.SHA512,
				keySize: 256 / 32,
				iterations: iterations
			});

			var decrypted = CryptoJS.AES.decrypt(encrypted, key, {iv: iv});
			var str = decrypted.toString(CryptoJS.enc.Utf8);
			return str;
		}
		catch(e) {
			console.log('ERROR: decryption invalid')
		}
	};

	return {
		init: init,
		decrypt: decrypt
	}
})(CryptoJS);

// Example 1 - text
var decryptedData1 = cryptoHelper.decrypt(JSON.parse(encryptedData1), 'mypassword');
var elemPlaceholderText = document.getElementById('js-decrypted-text');
elemPlaceholderText.innerText = decryptedData1;

// Example 2 - JSON
var decryptedData2 = cryptoHelper.decrypt(JSON.parse(encryptedData2), 'mypassword');
var elemPlaceholderJson = document.getElementById('js-decrypted-json');
elemPlaceholderJson.innerText = decryptedData2;