class AppStorage{

    storeToken(token){
        localStorage.setItem('token',token)
    }

    storeUser(user){
        localStorage.setItem('user',user)
    }

    storeUserId(userid){
        localStorage.setItem('userid',userid)
    }
    

    store(token,user,userid){
        this.storeToken(token)
        this.storeUser(user)
        this.storeUserId(userid)
    }


    getToken(){
        localStorage.getItem('token')
    }

    getUser(){
        localStorage.getItem('user')
    }

    clear(){
        localStorage.removeItem('token')
        localStorage.removeItem('user')
        localStorage.removeItem('userid')
    }


}


export default AppStorage = new AppStorage();