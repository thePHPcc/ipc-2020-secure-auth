window.addEventListener('load', function() {

    document.getElementById('loginWebAuthn').addEventListener('click', function(e) {

        e.preventDefault();
        let username = encodeURIComponent(document.getElementById('username').value);

        window.fetch('/webauthn/options?user=' + username, {
            method: 'GET',
            cache: 'no-cache'
        }).then(function (response) {
            return response.json();

            // convert base64 to arraybuffer
        }).then(function (json) {

            // error handling
            if (json.success === false) {
                throw new Error(json.msg);
            }

            // replace binary base64 data with ArrayBuffer. a other way to do this
            // is the reviver function of JSON.parse()
            recursiveBase64StrToArrayBuffer(json);
            return json;

            // create credentials
        }).then(function (getCredentialArgs) {
            return navigator.credentials.get(getCredentialArgs);
        }).then(function (cred) {
            return {
                id: cred.rawId ? arrayBufferToBase64(cred.rawId) : null,
                clientDataJSON: cred.response.clientDataJSON ? arrayBufferToBase64(cred.response.clientDataJSON) : null,
                authenticatorData: cred.response.authenticatorData ? arrayBufferToBase64(cred.response.authenticatorData) : null,
                signature: cred.response.signature ? arrayBufferToBase64(cred.response.signature) : null
            };
        }).then(JSON.stringify).then(window.btoa).then(function (AuthenticatorAttestationResponse) {
            console.log(AuthenticatorAttestationResponse);
            document.getElementById('webauthn').value = AuthenticatorAttestationResponse;
            document.getElementById('form').submit();
        }).catch(function (err) {
            window.alert(err.message || 'unknown error occured');
        });

        return false;
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
