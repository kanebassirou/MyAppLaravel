/*
script pour la verification des enregistreement des
*/
$(document).ready(function() {
    $('#register-user').click(function() {
      // Récupérer les valeurs des champs du formulaire
      var firstname = $('#firstname').val();
      var lastname = $('#lastname').val();
      var email = $('#email').val();
      var password = $('#password').val();
      var passwordConfirmation = $('#password-confirmation').val();
      var agreeTerms = $('#agreeTerms').is(':checked');
  
      // Réinitialiser les messages d'erreur
      $('.text-danger').text('');
  
      // Effectuer les validations
      var error = false;
  
      if (firstname === '') {
        $('#error-register-firstname').text('Veuillez entrer votre nom');
        $('#firstname').removeClass('is-valid').addClass('is-invalid');

        error = true;
      }else if (!isValidName(firstname)) {
        $('#error-register-firstname').text('Le nom doit contenir uniquement des lettres de l\'alphabet français');
        $('#firstname').removeClass('is-valid').addClass('is-invalid');

        error = true;
      } else {
        $('#firstname').removeClass('is-invalid').addClass('is-valid');
      }

  
      if (lastname === '') {
        $('#error-register-lastname').text('Veuillez entrer votre prénom');
        $('#lastname').removeClass('is-valid').addClass('is-invalid');

        error = true;
      }else if (!isValidName(lastname)) {
        $('#error-register-lastname').text('Le prénom doit contenir uniquement des lettres de l\'alphabet français');
        $('#lastname').removeClass('is-valid').addClass('is-invalid');

        error = true;
      }else {
        $('#lastname').removeClass('is-invalid').addClass('is-valid');
      }
  
      if (email === '') {
        $('#error-register-email').text('Veuillez entrer votre adresse e-mail');
        $('#error-register-email').removeClass('is-valid').addClass('is-invalid');
        error = true;
      } else if (!isValidEmail(email)) {
        $('#error-register-email').text('Veuillez entrer une adresse e-mail valide');
        $('#email').removeClass('is-valid').addClass('is-invalid');
        error = true;
      }else {
        $('#email').removeClass('is-invalid').addClass('is-valid');
      }
  
      if (password === '') {
        $('#error-register-password').text('Veuillez entrer votre mot de passe');
        $('#password').removeClass('is-valid').addClass('is-invalid');
        error = true;
        
      }else if (password.length < 8) {
        $('#error-register-password').text('Le mot de passe doit contenir au moins 8 caractères');
        $('#password').removeClass('is-valid').addClass('is-invalid');
        error = true;
      } else {
        $('#password').removeClass('is-invalid').addClass('is-valid');
      }
  
      if (passwordConfirmation === '') {
        $('#error-register-password-confirmation').text('Veuillez confirmer votre mot de passe');
        $('#password-confirmation').removeClass('is-valid').addClass('is-invalid');
        error = true;
      } else if (passwordConfirmation !== password) {
        $('#error-register-password-confirmation').text('Les mots de passe ne correspondent pas');
        $('#password-confirmation').removeClass('is-valid').addClass('is-invalid');
        error = true;
      }else {
        $('#password-confirmation').removeClass('is-invalid').addClass('is-valid');

      }
      
  
      if (!agreeTerms) {
        $('#error-register-agreeTerms').text('Veuillez accepter les termes et conditions');

        error = true;
      }
  
      // Soumettre le formulaire ou afficher les messages d'erreur
      if (error) {
        return false;
      } else {
        // Soumettre le formulaire
        var res = emailExistjs(email);
        // une condition ternaire
        (res != "exit")? $('#registerForm').submit()
        :  ($('#error-register-email').text('votre adress mail est deja utiliser'),
            $('#email').removeClass('is-valid').addClass('is-invalid'),
            error = true);     

      }
    });
  });
  
  function isValidEmail(email) {
    var regex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
    return regex.test(email);
  }
  function isValidName(name) {
    var regex = /^[a-zA-ZÀ-ÿ\s]+$/;
    return regex.test(name);
  }

  function emailExistjs(email){
    var url=$('#email').attr('url-emailExist');
    var token=$('#email').attr('token');
    var res = "";
    $.ajax({
      type :'POST',
      url:url,      
      data :{
        '_token':token,
        email :email
      },
      success: function(result) {
        res = result.response;
      },
      async:false
    });
    return res;
    
  } 
  
