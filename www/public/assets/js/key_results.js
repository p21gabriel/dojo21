let KeyResult = (function() {
    let title = $("#title");
    let objective_id = $("#objective_id");
    let description = $("#description");
    let type = $("#type");

    let validateForm = function () {
        if (!title.val().trim()) {
            alert('Informe um título!');
            return false;
        }

        if (!objective_id.val().trim()) {
            alert('Selecione um objetivo!');
            return false;
        }

        if (!description.val().trim()) {
            alert('Informe uma descrição!');
            return false;
        }

        if (!type.val().trim()) {
            alert('Selecione um tipo de Key Result!');
            return false;
        }

        return true;
    };

    let handleAdd = function() {
        $('#add').on("click", function (event) {
            if (!validateForm()) {
                return false;
            }

            let keyResultForm = $("#key-result-form-add").serialize();

            event.preventDefault();

            $.ajax({
                url: '/key_result/save',
                type: 'POST',
                contentType:"application/json;",
                dataType: "json",
                data: keyResultForm,
                success: function (data) {
                    console.log(data)
                    Global.redirect("/dashboard")
                },
                error: function (data) {
                    let response = JSON.parse(data.responseText);

                    alert(response.message);
                }
            });
        });
    }

    let handleEdit = function() {
        $('#edit').on("click", function (event) {
            if (!validateForm()) {
                return false;
            }

            let keyResultForm = $("#key-result-form-edit").serialize();

            event.preventDefault();

            $.ajax({
                url: '/key_result/update',
                type: 'POST',
                contentType:"application/json;",
                dataType: "json",
                data: keyResultForm,
                success: function (data) {
                    // console.log(data)
                    Global.redirect("/dashboard")
                },
                error: function (data) {
                    let response = JSON.parse(data.responseText);

                    alert(response.message);
                }
            });
        });
    }

    let handleDelete = function() {
        $('.delete').on("click", function (event) {
            event.preventDefault();

            let { target } = event;

            let id = $(target).data('id');

            $.ajax({
                url: `/key_result/${id}/delete`,
                type: 'POST',
                contentType:"application/json;",
                dataType: "json",
                data: {
                    key_result_id: id
                },
                success: function (data) {
                    alert("Excluído com sucesso!");

                    setTimeout(() => {
                        Global.reload();
                    }, 100)

                },
                error: function (data) {
                    let response = JSON.parse(data.responseText);

                    alert(response.message);
                }
            });
        });
    }


    let handleForm = () => {
        handleAdd();
        handleEdit();
        handleDelete();
    }

    return {
        init: () => {
            handleForm();
        }
    }
})();

jQuery(function() {
    KeyResult.init();
});