import React, {Fragment} from 'react';
import { Route } from 'react-router';
import { CreateEvent } from './create';
import { connect } from "react-redux";
import { push } from "react-router-redux";
import { EmailEventEdit } from './edit';
import { EventList } from '../../../domain/components/eventList';
import { CREATE_EVENT_ROUTE, UPDATE_EVENT_ROUTE } from "../../../routes";
import CustomizedBreadcrumbs from "../../../domain/components/breadCrumb";
import {DialogTitle, DialogContent, Slide} from '@material-ui/core';
import CustomDialog from "../../../domain/decorator/customDialog";

const Transition = React.forwardRef(function Transition(props, ref) {
    return <Slide direction="up" ref={ref} {...props} />;
});

const EmailEventList = (props) => {
    function handleClose() {
        props.push("/email-events");
    }

    return (
        <Fragment>
        <CustomizedBreadcrumbs name="Liste des évènements" link="/email-events"/>
        <EventList {...props} />
        <Route path={CREATE_EVENT_ROUTE}>
            {({match}) => (
                <CustomDialog
                    fullWidth
                    maxWidth={'md'}
                    open={!!match}
                    {...props}
                    onClose={handleClose} TransitionComponent={Transition}
                >
                    <DialogTitle>Ajouter un nouvel évènement</DialogTitle>
                    <DialogContent>
                        <CreateEvent onCancel={handleClose} {...props} />
                    </DialogContent>
                </CustomDialog>
            )}
        </Route>
        <Route path={UPDATE_EVENT_ROUTE}>
            {({match}) => {
                const isMatch = match && match.params && match.params.id !== "create";
                return (isMatch && (
                        <CustomDialog
                            {...props}
                            fullWidth
                            maxWidth={'md'}
                            open={!!isMatch}
                            onClose={handleClose}
                            aria-labelledby="Mèttre à jour l'évènement"
                            aria-describedby="Permet de modier les informations de l'évènement"
                        >
                            <DialogTitle>Mèttre à jour l'évènement</DialogTitle>
                            <DialogContent>
                                {isMatch ? (
                                    <EmailEventEdit
                                        id={match.params.id}
                                        onCancel={handleClose}
                                        {...props}
                                    />
                                ) : null}
                            </DialogContent>
                        </CustomDialog>
                    )
                );
            }}
        </Route>
    </Fragment>
    )
};

export default connect(
    undefined,
    { push }
)(EmailEventList);
