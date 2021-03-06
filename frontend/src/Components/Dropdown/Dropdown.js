import React, { useState } from "react";
import "./Dropdown.scss";
import { Link, useHistory } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { logout } from "../../Actions/user.actions";
import axios from "../../Helpers/axios";

function Dropdown() {
  const [click, setClick] = useState(false);
  const history = useHistory();
  const user = useSelector((state) => state.user);
  const token = localStorage.getItem("access_token");
  const dispatch = useDispatch();

  const logoutHandle = async () => {
    setClick(!click);
    try {
      const res = await axios.post(
        "/user/logout",
        {},
        {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      );
      if (res.status === 200) {
        dispatch(logout());
        history.push("/login");
      }
    } catch (error) {
      console.log(error.message);
    }
  };

  const handleClick = () => {
    console.log(click);
    setClick(!click);
  };

  return (
    <>
      <ul
        onClick={handleClick}
        className={click ? "dropdown-menu clicked" : "dropdown-menu"}
      >
        <li>
          <Link className="dropdown-link" to="/login" onClick={logoutHandle}>
            Logout
          </Link>
        </li>
      </ul>
    </>
  );
}

export default Dropdown;
