function addBlackList(url) {
    $.ajax({
        url: url,
        type: "POST",
        dataType: "JSON",
        beforeSend: function (jqXHR, settings) {
            alert('antes');
            console.log(url);
        },
        success: function (response, textStatus, jqXHR) {
            if (response.error) {
                alert("erro")
            } else {
                alert("ok");
            }

        },
        error: function (jQueryXHR, textStatus, errorThrow) {
            alert("erro 2");
        },
        complete: function (jQueryXHR, textStatus) {
            alert("complete");
        }
    });

}