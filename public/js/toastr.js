let showToast = (data) => {
    if(data.status == "success") {
        iziToast.success(data)
    } else if(data.status == "error") {
        iziToast.error(data)
    } else {
        iziToast.show(data)
    }
}

showToast(data)