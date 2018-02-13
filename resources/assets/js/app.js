
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');

import React from 'react';
import { render } from 'react-dom';
import { Router, Route, browserHistory } from 'react-router';


import Master from './components/Master';
import CreateProject from './components/CreateProject';
import DisplayProject from './components/DisplayProject';
import UpdateProject from './components/UpdateProject';
import DisplayMember from './components/DisplayMember';
import ShowDetailProject from './components/ShowDetailProject';
import AddMemberProject from './components/AddMemberProject';
import DeleteProject from './components/DeleteProject';
import UpdateMember from './components/UpdateMember';
import DeleteMember from './components/DeleteMember';
import ShowDetailMember from './components/ShowDetailMember';
import CreateMember from './components/CreateMember';


render(
    <Router history={browserHistory}>
        <Route path="/" component={Master} >
            <Route path = "/add-item" component = {CreateProject} />
            <Route path = "/display-item" component = {DisplayProject} />
            <Route path = "/display-item-member" component= {DisplayMember} />
            <Route path = "/edit-item/:id" component = {UpdateProject} />
            <Route path = "/show-detail-item/:id" component = {ShowDetailProject} />
            <Route path = "/add-member-project/:id" component = {AddMemberProject} />
            <Route path = "/delete-item/:id" component = {DeleteProject} />
            <Route path = "/add-item-member" component = {CreateMember} />
            <Route path = "/edit-item-member/:id" component = {UpdateMember} />
            <Route path = "/member/delete-item/:id" component = {DeleteMember} />
            <Route path = "/show-item-member/:id" component = {ShowDetailMember} />

        </Route>
    </Router>,
    document.getElementById('crud-app'));