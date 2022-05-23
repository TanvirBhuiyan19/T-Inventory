import AppStorage from './AppStorage';
import Token from './Token';

class User{

    responseAfterLogin(res){
        const access_token = res.data.access_token
        const username = res.data.name
        const userid = res.data.user_id
        if(Token.isValid(access_token)){
            AppStorage.store(access_token,username,userid)
        }
        return false
    }

    hasToken(){
        const getToken = localStorage.getItem('token')
        if(getToken){
            return Token.isValid(getToken) ? true : false
        }
        return false
    }

    loggedIn(){
        return this.hasToken()
    }

    loggedOut(){
        AppStorage.clear()
    }

    name(){
        if(this.loggedIn()){
            return localStorage.getItem('user')
        }
        return false
    }

    id(){
        if(this.loggedIn()){
            const payload =  Token.payload(localStorage.getItem('token'))
            return payload.sub
        }
        return false
    }


}



export default User = new User();