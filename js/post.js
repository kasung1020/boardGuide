document.querySelectorAll('.post-title').forEach(function(elem) {
    if (elem.innerText.length > 29) { // 31글자로 제한
        elem.innerText = elem.innerText.substring(0, 29);
    }
});