let Objective = (() => {
    let title = $("#title");
    let description = $("#description");
    let validateForm = function () {
        if (!title.val().trim()) {
            alert('Informe um título!');
            return false;
        }

        if (!description.val().trim()) {
            alert('Informe uma descrição!');
            return false;
        }

        return true;
    };

    let handleAdd = function () {
        $('#save').on("click", function (event) {
            event.preventDefault();

            if (!validateForm()) {
                return false;
            }

            let userForm = $("#objective-form").serialize();

            $.ajax({
                url: '/objective/save',
                type: 'POST',
                contentType:"application/json;",
                dataType: "json",
                data: userForm,
                success: function (data) {
                    $("#title").val('');
                    $("#description").val('');

                    alert("Cadastrado com sucesso!");

                    Global.redirect('/dashboard');

                },
                error: function (data) {
                    let response = JSON.parse(data.responseText);

                    alert(response.message);
                }
            });
        })
    }

    let handleEdit = function () {
        $('#edit').on("click", function (event) {
            event.preventDefault();

            if (!validateForm()) {
                return false;
            }

            let userForm = $("#objective-form-edit").serialize();

            $.ajax({
                url: '/objective/update',
                type: 'POST',
                contentType:"application/json;",
                dataType: "json",
                data: userForm,
                success: function (data) {
                    $("#title").val('');
                    $("#description").val('');

                    alert("Editado com sucesso!");

                    Global.redirect('/dashboard');

                },
                error: function (data) {
                    let response = JSON.parse(data.responseText);

                    alert(response.message);
                }
            });
        });
    }

    let handleDelete = function () {
        $('.delete').on("click", function (event) {
            event.preventDefault();

            let { target } = event;

            let id = $(target).data('id');

            $.ajax({
                url: `/objective/${id}/delete`,
                type: 'POST',
                contentType:"application/json;",
                dataType: "json",
                data: {
                    objective_id: id
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

            console.log(target);
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
    Objective.init();
});