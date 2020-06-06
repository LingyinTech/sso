;(function () {

    $('.action-add').on('click', function () {

        let that = this;

        axios({
            method: 'post',
            url: '/developer/create',
            data: {
                white_list: $(that).parents('tr').children('td').children('textarea[name=white_list]').val().trim(),
            }
        }).then((e) => {
            console.log(e);
            if (403 === e.status) {
            } else if (0 === e.data.code) {
                layer.msg('填加成功')
            } else {
                layer.msg(e.data.msg);
            }
        }).catch((e) => {
            console.log(e);
        })
    });

})();
