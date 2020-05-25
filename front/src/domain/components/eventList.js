import React from 'react';
import Card from '@material-ui/core/Card';
import CardActions from '@material-ui/core/CardActions';
import CardHeader from '@material-ui/core/CardHeader';
import CardContent from '@material-ui/core/CardContent';
import { 
    List, 
    TextField, 
    RichTextField, 
    TopToolbar, 
    ShowButton, 
    CreateButton, 
    EditButton, 
    DeleteButton
} from 'react-admin';
import { PAGINATION_LIMIT } from '../../Endpoint';
import listStyles from "../../assets/components/listStyle";

const EmailEventListActions = ({ basePath }) => (
    <TopToolbar>
        <CreateButton label={"Nouvel évènement"} basePath={basePath} />
    </TopToolbar>
);

function EventGrid ({ ids, data, basePath }) {
    const classes = listStyles();

    return (
        <div className={classes.container}>
            <CardHeader key={"event-list-header"}
                title="Liste des évènements"
                subheader="Les évènements déjà existants (ces évènements déclanchent l'envoi d'un email au client s'ils sont activés)"
            />
            {ids.map(id =>
                <Card key={`${id}-0`} className={classes.root} >
                    <CardHeader key={`${id}-1`}
                        title={<TextField record={data[id]} source="code" />}
                    />
                     <CardContent key={`${id}-2`} className={classes.content}>
                        <RichTextField record={data[id]} source="description" />
                    </CardContent>

                    <CardActions key={`${id}-3`} className={classes.actions}>
                        <ShowButton label="Voir" resource="id" basePath={basePath} record={data[id]} />
                        <EditButton label="Modifier" resource="id" basePath={basePath} record={data[id]} />
                        <DeleteButton label="Supprimer" resource="id" basePath={basePath} record={data[id]} />
                    </CardActions>
                </Card>
            )}
        </div>
    )
};

EventGrid.defaultProps = {
    data: {},
    ids: []
};

export const EventList = (props) => (
    <List 
        title="Liste des évènements"
        {...props }
        perPage={PAGINATION_LIMIT} 
        sort={{ field: 'code', order: 'DESC' }} 
        actions={<EmailEventListActions />}
    >
        <EventGrid />
    </List>
);