//firebase.auth().onAuthStateChanged(function(user {
//    if(user){
//        //user is signed in
//        document.getElementById("user_div").style.display = "block";
//        document.getElementById("login_div").style.display = "none";
//    }
//    else {
//        //No user is signed in
//        document.getElementById("user_div").style.display = "none";
//        document.getElementById("login_div").style.display = "block";
//    }
//}));
const user = firebase.auth().currentUser;

if (user) 
{
    document.getElementById("user_div").style.display = "block";
    document.getElementById("login_div").style.display = "none";
} 
else 
{
    document.getElementById("user_div").style.display = "none";
    document.getElementById("login_div").style.display = "block";
};


function login(){
    
    var userEmail = document.getElementById("email").value;
    var userPass = document.getElementById("password").value;
    
}