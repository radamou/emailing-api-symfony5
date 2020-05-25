import React from "react";
import {Dialog} from '@material-ui/core';

const CustomDialog = ({
                          basePath,
                          hasList,
                          hasEdit,
                          hasShow,
                          hasCreate,
                          push,
                          ...rest
}) => <Dialog {...rest}/>;

export default CustomDialog;