import {ADMIN_HOST} from "../routes";

const routes = [
    {
        id: 1,
        name: "Dashboard",
        to: "#",
        icon: "dashboardIcon",
        state: false,
        selected: false,
        children: [
            {
                name: "Fil de l'eau",
                to: `${ADMIN_HOST}/admin`,
                icon: "brushIcon"
            },
            {
                name: "Opérations",
                to: `${ADMIN_HOST}/admin/operations-dashboard`,
                icon: "settingsIcon"
            }
        ]
    },
    {
        id: 2,
        name: "Transporteurs",
        to: "#",
        icon: "transportIcon",
        state: false,
        selected: false,
        children: [
            {
                name: "Liste des transporteurs",
                to: `${ADMIN_HOST}/admin/carrier/`,
                icon: "menuIcon"
            },
            {
                name: "Surcharges",
                to: `${ADMIN_HOST}/admin/carrier/extra-charge`,
                icon: "priceIcon"
            },
            {
                name: "Vérifier une facture",
                to: `${ADMIN_HOST}/admin/carrier/check-monthly-bill`,
                icon: "priceIcon"
            },
        ]
    },
    {
        id: 3,
        name: "Prix",
        to: "#",
        icon: "priceIcon",
        state: false,
        selected: false,
        children: [
            {
                name: "Calcul prix pro",
                to: `${ADMIN_HOST}/admin/pricing/get-selling-price/pro`,
                icon: "visibility"
            },
            {
                name: "Calcul prix particulier",
                to: `${ADMIN_HOST}/admin/pricing/get-selling-price/ind`,
                icon: "visibility"
            },
            {
                name: "Offres Sympl",
                to: `${ADMIN_HOST}/admin/sympl-offer/`,
                icon: "airPlane"
            }
        ]
    },
    {
        id: 4,
        name: "Commandes",
        to: "#",
        icon: "commandIcon",
        state: false,
        selected: false,
        children:[
            {
                name: "Liste des commandes",
                to: `${ADMIN_HOST}/admin/command/`,
                icon: "menuIcon"
            },
            {
                name: "Importer",
                to: `${ADMIN_HOST}/admin/command/import`,
                icon: "createIcon"
            },
            {
                name: "Générer des étiquettes",
                to: `${ADMIN_HOST}/admin/command/bulk-labels-printing`,
                icon: "createIcon"
            },
            {
                name: "Échanges",
                to: `${ADMIN_HOST}/admin/command-exchange/`,
                icon: "syncIcon"
            },
            {
                name: "Bons de livraison",
                to: `${ADMIN_HOST}/admin/delivery-slip-batch`,
                icon: "airPlane"
            },
            {
                name: "Picking en attente",
                to: `${ADMIN_HOST}/admin/command/unpause-picking`,
                icon: "hourGlass"
            },
            {
                name: "Bordereau de dépôt",
                to: `${ADMIN_HOST}/admin/deposit-slip/`,
                icon: "printProof"
            },
            {
                name: "Imports shipments",
                to: `${ADMIN_HOST}/admin/command-manual-shipment/`,
                icon: "warning"
            },
        ]
    },
    {
        id: 5,
        name: "Opérations",
        to: "#",
        icon: 'operationIcon',
        state: false,
        selected: false,
        children: [
            {
                name: "Liste des opérations",
                to: `${ADMIN_HOST}/admin/customer-operation/`,
                icon: "menuIcon"
            },
            {
                name: "Créer une opération",
                to: `${ADMIN_HOST}/admin/customer-operation/create`,
                icon: "createIcon"
            },
            {
                name: "Vendeurs",
                to: `${ADMIN_HOST}/admin/operation-manager/`,
                icon: "priceIcon"
            }
        ]
    },
    {
        id: 6,
        name: "Livraisons",
        to: "#",
        icon: 'truckIcon',
        state: false,
        selected: false,
        children: [
            {
                name: "Liste des opérations",
                to: `${ADMIN_HOST}/admin/delivery-operation/`,
                icon: "menuIcon"
            },
            {
                name: "Créer une opération",
                to: `${ADMIN_HOST}/admin/delivery-operation/create`,
                icon: "createIcon"
            }
        ]
    },
    {
        id: 7,
        name: "Utilisateurs",
        to: "#",
        icon: 'userIcon',
        state: false,
        selected: false,
        children: [
            {
                name: "Liste des utilisateurs",
                to: `${ADMIN_HOST}/admin/user`,
                icon: "searchIcon"
            },
            {
                name: "Utilisateurs sous contrats",
                to: `${ADMIN_HOST}/admin/user?companiesWithContract=1`,
                icon: "searchIcon"
            },
            {
                name: "Clients à facturer",
                to: `${ADMIN_HOST}/admin/user/customer-to-charge`,
                icon: "priceIcon"
            },
            {
                name: "Ouvrir un compte pro",
                to: `${ADMIN_HOST}/admin/user/create-professional`,
                icon: "createIcon"
            },
            {
                name: "Créer un coursier",
                to: `${ADMIN_HOST}/admin/user/create-courier`,
                icon: "createIcon"
            },
            {
                name: "Ouvrir un emballeur",
                to: `${ADMIN_HOST}/admin/user/create-warehouse-worker`,
                icon: "createIcon"
            }
        ]
    },
    {
        id: 8,
        name: "Coursiers",
        to: "#",
        icon: 'driveIcon',
        state: false,
        selected: false,
        children: [
            {
                name: "Carte des coursiers",
                to: `${ADMIN_HOST}/admin/courier/`,
                icon: "searchIcon"
            },
            {
                name: "Annuler une course",
                to: `${ADMIN_HOST}/admin/courier/cancel-course`,
                icon: "cancelIcon"
            }
        ]
    },
    {
        id: 9,
        name: "Paiements",
        to: "#",
        icon: 'priceIcon',
        state: false,
        selected: false,
        children: [
            {
                name: "Obtenir un rapport",
                to: `${ADMIN_HOST}/admin/payment-operation/report`,
                icon: "creditCard"
            },
            {
                name: "Opérations bancaires",
                to: `${ADMIN_HOST}/admin/payment-operation/`,
                icon: "creditCard"
            },
            {
                name: "Factures Clients",
                to: `${ADMIN_HOST}/admin/courier/invoice/`,
                icon: "creditCard"
            },
            {
                name: "Echecs de paiement",
                to: `${ADMIN_HOST}/admin/payment-failures/`,
                icon: "creditCard"
            }
        ]
    },
    {
        id: 10,
        name: "Zones couvertes",
        to: "#",
        icon: 'areaMapIcon',
        state: false,
        selected: false,
        children: [
            {
                name: "Collectes",
                to: `${ADMIN_HOST}/admin/available-zone/`,
                icon: "areaMapIcon"
            },
            {
                name: "Echanges",
                to: `${ADMIN_HOST}/admin/tour`,
                icon: "creditCard"
            }
        ]
    },
    {
        id: 11,
        name: "Tournées",
        to: `${ADMIN_HOST}/admin/available-zone/`,
        icon: 'areaMapIcon'
    },
    {
        id: 12,
        name: "Jours d'ouverture",
        to: `${ADMIN_HOST}/admin/opening-time/`,
        icon: 'eventIcon'
    },
    {
        id: 13,
        name: "Messages aux clients",
        to: `${ADMIN_HOST}/admin/customer-message/`,
        icon: 'messageIcon'
    },
    {
        id: 14,
        name: "Notices",
        to: `${ADMIN_HOST}/admin/help/`,
        icon: 'helpIcon'
    },
    {
        id: 15,
        name: "Gestion de stock",
        to: "#",
        icon: 'menuIcon',
        state: false,
        selected: false,
        children: [
            {
                name: "Entreprises",
                to: `${ADMIN_HOST}/admin/stock/`,
                icon: "companyIcon"
            },
            {
                name: "Sorties",
                to: `${ADMIN_HOST}/admin/stock/outflow`,
                icon: "creditCard"
            }
        ]
    },
    {
        id: 16,
        name: "QR Codes",
        to: `${ADMIN_HOST}/admin/qr-code-batch/`,
        icon: 'qrCodeIcon'
    }
];

export default routes;