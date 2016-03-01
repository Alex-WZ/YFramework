var indexPage = {
	flashContent :function(contentUrl){
		$.ajax({
			url:"index/" + contentUrl,
			method:"GET",
			success:function(resp){
				alert(resp);
			}

		})
	}
}