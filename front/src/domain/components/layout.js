import React from 'react';
import { Layout } from 'react-admin';
import MyAppBar from './appBar';
import MyMenu from "./menu";

const MyLayout = (props) => <Layout {...props} appBar={MyAppBar} menu={MyMenu}/>;

export default MyLayout;