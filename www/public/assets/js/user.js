let User = (function() {
    let name = $("#name");
    let email = $("#email");
    let password = $("#password");

    let validateForm = function () {
        if (!name.val().trim()) {
            alert('Informe o seu nome!');
            return false;
        }

        if (!email.val().trim()) {
            alert('Informe o seu e-mail!');
            return false;
        }

        if (!password.val().trim()) {
            alert('Informe sua senha!');
            return false;
        }

        return true;
    };

    let handleForm = function() {
        $('#cadastrar').on("click", function (event) {
            if (!validateForm()) {
                return false;
            }

            let userForm = $("#user-form").serialize();

            event.preventDefault();
            $.ajax({
                url: '/user/save',
                type: 'POST',
                contentType:"application/json;",
                dataType: "json",
                data: userForm,
                success: function (data) {
                    if (data.result !== 'success') {
                        alert('Nome inválido ou não preenchido!');
                    }

                    Global.redirect('/login');
                },
                error: function (data) {
                    let response = JSON.parse(data.responseText);

                    alert(response.message);
                }
            });
        });
    }

    return {
        init: () => {
            handleForm();
        }
    }
})();

jQuery(function() {
    User.init();
});