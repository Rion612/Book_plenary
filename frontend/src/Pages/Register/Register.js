import React, { useState,useEffect } from "react";
import { useSelector } from "react-redux";
import { Link, useHistory } from "react-router-dom";
import {
  passwordMatch,
  validateEmailHandler,
  validateName,
  validatePasswordHandler,
} from "../../Commonfiles/functions/commonFunction";
import Layout from "../../Components/Layouts/Layout";
import Input from "../../Components/UI/Input";
import axios from "../../Helpers/axios";

import "./register.scss";
const Register = () => {
  const history = useHistory();
  const user = useSelector(state=>state.user);
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [password_confirmation, setPassword_confirmation] = useState("");
  const [sucessMessage, setSuccessMessage] = useState(false);
  const [passwordIsValid, setPasswordIsValid] = useState();
  const [passwordMatchValid, setPasswordMatchValid] = useState();
  const [emailIsValid, setEmailIsValid] = useState();
  const [nameIsValid, setNameIsValid] = useState();
  const [formIsValid, setFormIsValid] = useState(false);
  const [failureMessage, setFailureMessage] = useState(false);


  useEffect(() => {
    const identifier = setTimeout(() => {
      console.log(formIsValid);
      setFormIsValid(
        validateEmailHandler(email) &&
          validatePasswordHandler(password) && passwordMatch(password,password_confirmation) && validateName(name)
      );
    }, 500);

    return () => {
      clearTimeout(identifier);
    };
  }, [email,password,name,password_confirmation]);

  const alerClose = () => {
    setSuccessMessage(false);
    setFailureMessage(false);
  };
  const formSubmit = async (event) => {
    event.preventDefault();
    const user = {
      name,
      email,
      password,
      password_confirmation,
    };
    console.log(user);
    try {
      const res = await axios.post("/user/register", user);
      if (res.status === 200) {
        console.log(res.data);
        setSuccessMessage(true);

        setEmail("");
        setName("");
        setPassword("");
        setPassword_confirmation("");
      }
    } catch (error) {
      console.log(error.message);
      setFailureMessage(true);
    }
  };
  if (user.authenticate) {
    history.push("/");
  }
  return (
    <Layout>
      <div className="rMainDiv">
        <div className="rFormDiv">
          <form onSubmit={formSubmit}>
            <h1>Registration</h1>
            {sucessMessage ? (
              <div className="alertMessage">
                <span className="closebtn" onClick={alerClose}>
                  &times;
                </span>
                <strong>Registration success!</strong><br/>A verification email was
                sent to your email.
              </div>
            ) : null}
            {failureMessage ? (
              <div className="falertMessage">
                <span className="closebtn" onClick={alerClose}>
                  &times;
                </span>
                <strong>Registration failure!</strong>
              </div>
            ) : null}
            <Input
              label="Full name:"
              type="text"
              placeholder="Enter your fullname"
              value={name}
              onChange={(e) => setName(e.target.value)}
              onBlur={(e)=>{
                setNameIsValid(validateName(name));
              }}
            />
            {nameIsValid === false ? (
              <span className="wrongInfo">Name should be greater than 3 characters</span>
            ) : (
              <span></span>
            )}
            <Input
              label="Email:"
              type="text"
              placeholder="Enter your email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              onBlur={(e) => {
                setEmailIsValid(validateEmailHandler(email));
              }}
            />
            {emailIsValid === false ? (
              <span className="wrongInfo">Email is invalid</span>
            ) : (
              <span></span>
            )}
            <Input
              label="Password:"
              type="password"
              placeholder="Enter your password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              onBlur={(e) => {
                setPasswordIsValid(validatePasswordHandler(password));
              }}
            />
            {passwordIsValid === false ? (
              <span className="wrongInfo">Password length should be greater than 6 characters</span>
            ) : (
              <span></span>
            )}
            <Input
              label="Repeat Password:"
              type="password"
              placeholder="Enter your password again"
              value={password_confirmation}
              onChange={(e) => setPassword_confirmation(e.target.value)}
              onBlur={(e)=>{
                setPasswordMatchValid(passwordMatch(password,password_confirmation));
              }}
            />
            {passwordMatchValid === false ? (
              <span className="wrongInfo">Password doesn't match</span>
            ) : (
              <span></span>
            )}
            <button type="submit" className="signupbtn" disabled={!formIsValid}>
              Sign Up
            </button>
            <p>
              Already registered? <Link to="/login">Please login.</Link>
            </p>
          </form>
        </div>
      </div>
    </Layout>
  );
};

export default Register;
