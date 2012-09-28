function search_confirm() {
	if (document.search_form.keyword.value == '') {
		alert('검색어를 입력하세요.');
		document.search_form.keyword.focus();
		return;
	}
	document.search_form.submit();
}


