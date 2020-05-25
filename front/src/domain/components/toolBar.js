import React from 'react';
import {
    Toolbar,
    SaveButton,
    translate,
    TopToolbar,
    ListButton,
} from 'react-admin';
import CustomButton from "../decorator/customButton";

export const CrudToolbar = translate(({ onCancel, translate, ...props }) => (
    <Toolbar {...props}>
        <SaveButton />
        <CustomButton onClick={onCancel}>{translate('ra.action.cancel')}</CustomButton>
    </Toolbar>
));

export const EventListShowActions = ({ basePath, data }) => (
    <TopToolbar>
        <ListButton label={"Liste des évènements"} basePath={basePath} record={data} />
    </TopToolbar>
);
