$('.datatables').DataTable()

let deleteItem = (url) => {
    $('#deleteForm').attr('action', url)
    $('#deleteForm').submit()
}