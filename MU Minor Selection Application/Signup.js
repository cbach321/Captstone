// register function for signup html
//function signup (){
//    email = document.getElementById('email').value
//    password = document.getElementById('password').value
//    fname = document.getElementById('fname').value
//    lname = document.getElementById('lname').value
//    
//// validate input 
//}
//if (validate_email(email) == false || validate_password(password) == false){
//    alert('Please enter valid email and/or password.')
//    return
//}
//if (validate_field(fname) == false || validate_field(lname) == false){
//    alert('Please enter a valid name')
//    return
//}
//
//auth.createUserWithEmailAndPassword(email, password)
//.then(function(){
//    var user = auth.currentUser
//    
//    var database_ref = database.ref()
//    
//    
//    var user_data = {
//        email: email,
//        fname: fname,
//        lname: lname
//        last_login: Date.now()
//    }
//    
//    database_ref.child('users/' + user.uid).set(user_data)
//    
//    
//    
//    alert('Account Successfully Created!')
//}
//.catch(function(error)){
//    var error_code = error.code
//    var error_message = error.message
//    
//    alert(error_message)
//})
