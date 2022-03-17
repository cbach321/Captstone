
 //register function for signup html
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
//})
//.catch(function(error){
//    var error_code = error.code
//    var error_message = error.message
//    
//    alert(error_message)
//})



//function login (){
//    email = document.getElementById('email').value
//    password = document.getElementById('password').value
//    
//    if (validate_email(email) == false || validate_password(password) == false){
//    alert('Please enter valid email and/or password.')
//    return
//    }
//    
//    auth.signInWithEmailAndPassword(email, password)
//    .then(function() {
//          var user = auth.currentUser
//    
//    var database_ref = database.ref()
//    
//    
//    var user_data = {
//        last_login: Date.now()
//    }
//    
//    database_ref.child('users/' + user.uid).update(user_data)
//    
//    
//    
//    alert('Account Successfully Logged In!')
//    })
//    .catch(function(error){
//    var error_code = error.code
//    var error_message = error.message
//    
//    alert(error_message)
//    })
//}
//
//function validate_email(email) {
//    expression = /^[^@]+@\w+(\.\w+)+\w$/
//    if (expression.test(email) == true) {
//        // Email is good
//        return true
//    }
//    else{
//        // Email is bad
//        return false
//    }
//}
//function validate_password(password){
//    if(password < 6){
//        return false
//    }
//    else{
//        return true
//    }
//}
//function validate_field(field){
//    if (field == null){
//        return false
//    }
//    if (field.length <= 0){
//        return false
//    }
//    else{
//        return true
//    }
//}

//login.addEventListener('click', (e)=>{
//    var email = document.getElementById('email').value;
//    var password = document.getElementById('password').value;
//    
//        signInWithEmailAndPassword(auth, email, password)
//        .then((userCredential) => {
//
//            const user = userCredential.user;
//            
//            const dt = new Date();
//            
//            update(ref(database, 'users/' + user.uid),{
//                last_login: dt
//            })
//            
//            alert('User logged in!'); 
//        })
//        .catch((error) =>{
//            const errorCode = error.code;
//            const errorMessage = error.message;
//            
//            alert(errorMessage);
//            
//        });
//});