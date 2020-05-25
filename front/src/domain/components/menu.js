import React, {createElement, useState} from 'react';
import { useSelector } from 'react-redux';
import {
    MenuItemLink,
    getResources
} from 'react-admin';
import routes from "../../data/data";
import ExpandLess from '@material-ui/icons/ExpandLess';
import ExpandMore from '@material-ui/icons/ExpandMore';
import Collapse from '@material-ui/core/Collapse';
import ListItem from '@material-ui/core/ListItem';
import MenuItem from '@material-ui/core/MenuItem';
import List from '@material-ui/core/List';
import ListItemText from '@material-ui/core/ListItemText';
import menuStyles from "../../assets/components/menuStyle";
import CustomMenuIcon from "./menuIcon";
import {externalMenuClick} from "../../infrastructure/security/secureHrefRedirection";

const MyMenu = ({ onMenuClick }) => {
    const open = useSelector(state => state.admin.ui.sidebarOpen);
    const [menus, setMenus] = useState(routes);
    const resources = useSelector(getResources);
    const classes = menuStyles();

    const handleExpandClick = (e) => {
        e.preventDefault();
        let id = parseInt(e.target.getAttribute('menu-key'));

        setMenus(menus.map(menu => ({
            ...menu,
            state: menu.id === id ? !menu.state: menu.state,
            selected: menu.id === id ? !menu.selected: menu.selected
        })));
    };

    return (
        <List component="nav" className={classes.root} aria-label="menu">
            {menus.map(
                menu => (
                    <React.Fragment key={menu.name}>
                        <MenuItem
                            key={menu.id}
                            className={classes.items}
                            divider={true}
                            selected={menu.selected}
                            href={`${menu.to}?token=${localStorage.getItem('token')}`}
                        >
                            <CustomMenuIcon icon={menu.icon} />
                            <ListItemText disableTypography primary={menu.name} onClick={externalMenuClick} external-key={menu.to}/>
                            {
                                menu.children && (menu.state ?
                                    <ExpandLess
                                        fontSize={"small"}
                                        className={classes.arrow}
                                        menu-key={menu.id}
                                        onClick={menu.children && handleExpandClick}
                                    /> :
                                    <ExpandMore
                                        fontSize={"small"}
                                        className={classes.arrow}
                                        menu-key={menu.id}
                                        onClick={menu.children && handleExpandClick}
                                    />
                                )
                            }
                        </MenuItem>
                        {
                            menu.children && (
                                <Collapse in={menu.state} timeout="auto" unmountOnExit>
                                    <List component="div">
                                        {menu.children.map(children => (
                                            <MenuItem href={`${children.to}?token=${localStorage.getItem('token')}`}
                                                      key={children.name}
                                                      divider={true}
                                                      className={classes.nested}
                                                      selected={children.selected}
                                            >
                                                <CustomMenuIcon icon={children.icon} />
                                                <ListItemText disableTypography primary={children.name}  onClick={externalMenuClick} external-key={children.to}/>
                                            </MenuItem>
                                        ))}
                                    </List>
                                </Collapse>
                            )
                        }
                    </React.Fragment>
                )
            )}
            {resources.map(resource => (
                resource.icon && (
                    <ListItem  divider={true} key={resource.name}  disableGutters>
                         <MenuItemLink disableGutters className={classes.raLink}
                             key={resource.name}
                             to={`/${resource.name}`}
                             primaryText={
                                (resource.options && resource.options.label) || resource.name
                             }
                             leftIcon={createElement(resource.icon)}
                             onClick={onMenuClick}
                             sidebarIsOpen={open}
                    />
                    </ListItem>)
            ))}
        </List>
    );
};

export default MyMenu;