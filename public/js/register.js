window.addEventListener('load', function() {

    document.getElementById('webauthn').addEventListener('click', function() {

        window.fetch('/webauthn/register/options', {
            method: 'GET',
            cache: 'no-cache'
        }).then(function (response) {
            return response.json();
        }).then(function (json) {

            // error handling
            if (json.success === false) {
                throw new Error(json.msg);
            }

            // replace binary base64 data with ArrayBuffer. a other way to do this
            // is the reviver function of JSON.parse()
            recursiveBase64StrToArrayBuffer(json);
            return json;

        }).then(function (createCredentialArgs) {
            return navigator.credentials.create(createCredentialArgs);

            // convert to base64
        }).then(function (cred) {

            return {
                clientDataJSON: cred.response.clientDataJSON ? arrayBufferToBase64(cred.response.clientDataJSON) : null,
                attestationObject: cred.response.attestationObject ? arrayBufferToBase64(cred.response.attestationObject) : null,
            };

            // transfer to server
        }).then(JSON.stringify).then(function (AuthenticatorAttestationResponse) {
            console.log('Sending: ' + AuthenticatorAttestationResponse);
            return window.fetch('/webauthn/register', {
                method: 'POST',
                body: AuthenticatorAttestationResponse,
                cache: 'no-cache',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            // convert to JSON
        }).then(function (response) {
            return response.json();

            // analyze response
        }).then(function (json) {
            if (json.success) {
                window.alert(json.msg || 'registration success');
            } else {
                throw new Error(json.msg);
            }

            // catch errors
        }).catch(function (err) {
            window.alert(err.message || 'unknown error occured');
        });


    });
});

/**
 * convert RFC 1342-like base64 strings to array buffer
 * @param {mixed} obj
 * @returns {undefined}
 */
function recursiveBase64StrToArrayBuffer(obj) {
    let prefix = '?BINARY?B?';
    let suffix = '?=';
    if (typeof obj === 'object') {
        for (let key in obj) {
            if (typeof obj[key] === 'string') {
                let str = obj[key];
                if (str.substring(0, prefix.length) === prefix && str.substring(str.length - suffix.length) === suffix) {
                    str = str.substring(prefix.length, str.length - suffix.length);

                    let binary_string = window.atob(str);
                    let len = binary_string.length;
                    let bytes = new Uint8Array(len);
                    for (var i = 0; i < len; i++) {
                        bytes[i] = binary_string.charCodeAt(i);
                    }
                    obj[key] = bytes.buffer;
                }
            } else {
                recursiveBase64StrToArrayBuffer(obj[key]);
            }
        }
    }
}

/**
 * Convert a ArrayBuffer to Base64
 * @param {ArrayBuffer} buffer
 * @returns {String}
 */
function arrayBufferToBase64(buffer) {
    var binary = '';
    var bytes = new Uint8Array(buffer);
    var len = bytes.byteLength;
    for (var i = 0; i < len; i++) {
        binary += String.fromCharCode(bytes[i]);
    }
    return window.btoa(binary);
}
