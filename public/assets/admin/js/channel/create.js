

let select2 = $('.select2')
// Default
if (select2.length) {
    select2.each(function () {
        var $this = $(this);
        $this.wrap('<div class="position-relative"></div>').select2({
            placeholder: 'انتخاب',
            dropdownParent: $this.parent()
        });
    });
}
