import React from 'react';
import Card from '@material-ui/core/Card';
import CardActions from '@material-ui/core/CardActions';
import CardHeader from '@material-ui/core/CardHeader';
import { List, TextField, ShowButton, EditButton, DeleteButton} from 'react-admin';
import { PAGINATION_LIMIT } from '../../Endpoint';
import listStyles from "../../assets/components/listStyle";

function TemplateGrid ({ ids, data, basePath }) {
    const  classes = listStyles();

    return (
        <div className={classes.container}>
             <CardHeader
                title="Contenus d'emails"
                subheader="List des tous les templates personnalisé des évènements déclanchants l'envoi d'emails aux clients"
            />
            {ids.map(id =>
                <Card key={id} className={classes.root}>
                    <CardHeader
                        title={<TextField record={data[id]} source="title" />}
                        subheader={<TextField record={data[id]} source="language" />}
                    />

                    <CardActions className={classes.actions}>
                        <ShowButton label="Voir" resource="id" basePath={basePath} record={data[id]} />
                        <EditButton label="Modifier" resource="id" basePath={basePath} record={data[id]} />
                        <DeleteButton label="Supprimer" resource="id" basePath={basePath} record={data[id]} />
                    </CardActions>
                </Card>
            )}
        </div>
    )
};

TemplateGrid.defaultProps = {
    data: {},
    ids: []
};

export const TemplateList = (props) => (
    <List
        title="Liste des templates" 
        {...props } 
        perPage={PAGINATION_LIMIT} 
        sort={{ field: 'code', order: 'DESC' }} 
    >
        <TemplateGrid />
    </List>
);