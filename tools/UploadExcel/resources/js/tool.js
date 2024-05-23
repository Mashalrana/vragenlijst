Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'upload-excel',
            path: '/upload-excel',
            component: require('./components/Tool'),
        },
    ])
})
