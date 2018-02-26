import React, {Component} from 'react';
import { Router, Route, Link } from 'react-router';


class Master extends Component
{
    render()
    {
        return (
            <div className="container">
                <nav className="navbar navbar-default">
                    <div className="container-fluid">
                        <ul className="nav navbar-nav">
                            <li><Link to="listproject">Project</Link></li>
                            <li><Link to="list">Member</Link></li>
                        </ul>
                    </div>
                </nav>
                <div>
                    {this.props.children}
                </div>
            </div>
        )
    }
}
export default Master;