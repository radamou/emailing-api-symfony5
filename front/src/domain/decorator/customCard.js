import React from "react";
import Card from '@material-ui/core/Card';

const CustomCard = ({
                          basePath,
                          hasList,
                          hasEdit,
                          hasShow,
                          hasCreate,
                          push,
                          ...rest
                      }) => <Card {...rest}/>;

export default CustomCard;