import React from 'react';
import Breadcrumbs from '@material-ui/core/Breadcrumbs';
import { HOME_PAGE_URL } from "../../routes";
import { breadCrumbStyle } from "../../assets/components/breadCrumbStyle";
import Link from '@material-ui/core/Link';

export default function CustomizedBreadcrumbs(props) {
    const classes = breadCrumbStyle();

    return (
        <Breadcrumbs separator={">"} className={classes.root} >
            <Link color="inherit" component="a" href={HOME_PAGE_URL} label="Home">Home</Link>
            <Link color="inherit" component="a" href={props.link} label={props.name}>
                {props.name}
            </Link>
        </Breadcrumbs>
    );
}