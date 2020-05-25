import React from "react";
import Dashboard from "@material-ui/icons/Dashboard";
import EmojiTransportationIcon from "@material-ui/icons/EmojiTransportation";
import EuroIcon from "@material-ui/icons/Euro";
import LocalAirportIcon from "@material-ui/icons/LocalAirport";
import ShoppingBasketIcon from "@material-ui/icons/ShoppingBasket";
import BusinessCenterIcon from "@material-ui/icons/BusinessCenter";
import LocalShippingIcon from "@material-ui/icons/LocalShipping";
import PeopleIcon from "@material-ui/icons/People";
import SearchIcon from "@material-ui/icons/Search";
import DriveEtaIcon from "@material-ui/icons/DriveEta";
import RoomIcon from "@material-ui/icons/Room";
import CancelIcon from "@material-ui/icons/Cancel";
import CreditCardIcon from "@material-ui/icons/CreditCard";
import MapIcon from "@material-ui/icons/Map";
import MenuIcon from "@material-ui/icons/Menu";
import AddCircleIcon from "@material-ui/icons/AddCircle";
import SettingsIcon from '@material-ui/icons/Settings';
import BrushIcon from '@material-ui/icons/Brush';
import VisibilityTwoToneIcon from '@material-ui/icons/VisibilityTwoTone';
import AirplanemodeActiveTwoToneIcon from '@material-ui/icons/AirplanemodeActiveTwoTone';
import SyncAltTwoToneIcon from '@material-ui/icons/SyncAltTwoTone';
import HourglassEmptyTwoToneIcon from '@material-ui/icons/HourglassEmptyTwoTone';
import LocalPrintshopTwoToneIcon from '@material-ui/icons/LocalPrintshopTwoTone';
import WarningTwoToneIcon from '@material-ui/icons/WarningTwoTone';
import ShoppingBasketTwoToneIcon from '@material-ui/icons/ShoppingBasketTwoTone';
import EventNoteTwoToneIcon from '@material-ui/icons/EventNoteTwoTone';
import MessageTwoToneIcon from '@material-ui/icons/MessageTwoTone';
import HelpOutlineTwoToneIcon from '@material-ui/icons/HelpOutlineTwoTone';
import CropFreeTwoToneIcon from '@material-ui/icons/CropFreeTwoTone';
import BusinessTwoToneIcon from '@material-ui/icons/BusinessTwoTone';
import ExitToAppTwoToneIcon from '@material-ui/icons/ExitToAppTwoTone';
import ListItemIcon from "@material-ui/core/ListItemIcon";
import { menuIconStyles } from "../../assets/components/menuIconStyle";

const CustomMenuIcon = ({ icon }) => {
    const classes = menuIconStyles();

    switch (icon) {
        case 'dashboardIcon': return <ListItemIcon className={classes.root}><Dashboard fontSize={"small"}/></ListItemIcon>;
        case 'transportIcon': return <ListItemIcon className={classes.root}><EmojiTransportationIcon  fontSize={"small"}/></ListItemIcon>;
        case 'priceIcon': return <ListItemIcon className={classes.root}><EuroIcon  fontSize={"small"}/></ListItemIcon>;
        case 'commandIcon': return <ListItemIcon className={classes.root}><LocalAirportIcon  fontSize={"small"} /></ListItemIcon>;
        case 'roundIcon': return <ListItemIcon className={classes.root}><ShoppingBasketIcon  fontSize={"small"} /></ListItemIcon>;
        case 'operationIcon': return <ListItemIcon className={classes.root}><BusinessCenterIcon  fontSize={"small"} /></ListItemIcon>;
        case 'truckIcon': return <ListItemIcon className={classes.root}><LocalShippingIcon  fontSize={"small"} /></ListItemIcon>;
        case 'userIcon': return <ListItemIcon className={classes.root}><PeopleIcon fontSize={"small"} /></ListItemIcon>;
        case 'searchIcon': return <ListItemIcon className={classes.root}> <SearchIcon  fontSize={"small"} /></ListItemIcon>;
        case 'driveIcon': return <ListItemIcon className={classes.root}><DriveEtaIcon  fontSize={"small"} /></ListItemIcon>;
        case 'mapIcon': return <ListItemIcon className={classes.root}><RoomIcon  fontSize={"small"} /></ListItemIcon>;
        case 'cancelIcon': return <ListItemIcon className={classes.root}><CancelIcon  fontSize={"small"} /></ListItemIcon>;
        case 'creditCard': return <ListItemIcon className={classes.root}><CreditCardIcon  fontSize={"small"} /></ListItemIcon>;
        case 'areaMapIcon': return <ListItemIcon className={classes.root}><MapIcon  fontSize={"small"} /></ListItemIcon>;
        case 'menuIcon': return <ListItemIcon className={classes.root}><MenuIcon  fontSize={"small"} /></ListItemIcon>;
        case 'createIcon': return <ListItemIcon className={classes.root}><AddCircleIcon  fontSize={"small"} /></ListItemIcon>;
        case 'settingsIcon': return <ListItemIcon className={classes.root}><SettingsIcon  fontSize={"small"} /></ListItemIcon>;
        case 'brushIcon': return <ListItemIcon className={classes.root}><BrushIcon  fontSize={"small"} /></ListItemIcon>;
        case 'visibility': return <ListItemIcon className={classes.root}><VisibilityTwoToneIcon  fontSize={"small"} /></ListItemIcon>;
        case 'airPlane': return <ListItemIcon className={classes.root}><AirplanemodeActiveTwoToneIcon  fontSize={"small"} /></ListItemIcon>;
        case 'syncIcon': return <ListItemIcon className={classes.root}><SyncAltTwoToneIcon fontSize={"small"} /></ListItemIcon>;
        case 'hourGlass': return <ListItemIcon className={classes.root}><HourglassEmptyTwoToneIcon fontSize={"small"} /></ListItemIcon>;
        case 'printProof': return <ListItemIcon className={classes.root}><LocalPrintshopTwoToneIcon fontSize={"small"} /></ListItemIcon>;
        case 'warning': return <ListItemIcon className={classes.root}><WarningTwoToneIcon fontSize={"small"} /></ListItemIcon>;
        case 'basketIcon': return <ListItemIcon className={classes.root}><ShoppingBasketTwoToneIcon fontSize={"small"} /></ListItemIcon>;
        case 'eventIcon': return <ListItemIcon className={classes.root}><EventNoteTwoToneIcon fontSize={"small"} /></ListItemIcon>;
        case 'messageIcon': return <ListItemIcon className={classes.root}><MessageTwoToneIcon fontSize={"small"} /></ListItemIcon>;
        case 'helpIcon': return <ListItemIcon className={classes.root}><HelpOutlineTwoToneIcon fontSize={"small"}/></ListItemIcon>;
        case 'qrCodeIcon': return <ListItemIcon className={classes.root}><CropFreeTwoToneIcon fontSize={"small"}/></ListItemIcon>;
        case 'companyIcon': return <ListItemIcon className={classes.root}><BusinessTwoToneIcon fontSize={"small"} /></ListItemIcon>;
        case 'signeOut': return <ListItemIcon className={classes.root}><ExitToAppTwoToneIcon fontSize={"small"} /></ListItemIcon>;
        default: return null
    }
};

export default CustomMenuIcon;