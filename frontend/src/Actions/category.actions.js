import axios from "../Helpers/axios";
import { categoryConstants } from "./constants";

export const getAllCategories = () => {
    return async dispatch => {
        dispatch({ type: categoryConstants.GET_Category_REQUEST});


        await axios.get('/get/all/categories')
            .then((res) => {
                if (res.status === 200) {

                    dispatch({
                        type: categoryConstants.GET_Category_SUCCESS,
                        payload: {
                            categories : res.data.categories
                        }
                    })
                }
                else {
                    dispatch({
                        type: categoryConstants.GET_Category_FAILURE,
                        payload: {
                            message: "something wrong!"
                        }
                    })
                }

            })
            .catch((error) => {
                dispatch({
                    type: categoryConstants.GET_Category_FAILURE,
                    payload: {
                        message: "something wrong!"
                    }
                })

            });
    }
}