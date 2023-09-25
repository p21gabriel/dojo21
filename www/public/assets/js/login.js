let Login = (function() {
    let handleForm = function() {
        $('#logar').on("click", function (event) {
            event.preventDefault();
            let loginForm = $("#login-form").serialize();

            $.ajax({
                url: '/user/login',
                type: 'POST',
                data: loginForm,
                contentType:"application/json;",
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    Global.redirect('/dashboard');
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
    Login.init();
});