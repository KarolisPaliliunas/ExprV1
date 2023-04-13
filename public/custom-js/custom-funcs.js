function generateGroupCode() {
    var length = 8,
        charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
        generatedCode = "";
    for (var i = 0, n = charset.length; i < length; ++i) {
        generatedCode += charset.charAt(Math.floor(Math.random() * n));
    }
    document.getElementById('joinCodeInput').value = generatedCode;
}