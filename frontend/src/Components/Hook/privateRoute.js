import React from 'react';
import { Redirect, Route } from 'react-router-dom';

const PrivateRoute=({component:Component, ...rest})=>{
    return <Route {...rest} component={(props)=>{
        const token = window.localStorage.getItem('access_token');

        if(token){
            return <Component {...props}/>

        }
        else{
            return <Redirect to={'/login'}/>
        }

    }}/>
    
}

export default PrivateRoute;