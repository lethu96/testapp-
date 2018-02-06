import React, { Component } from 'react';
import { Link, browserHistory } from 'react-router';
import MyGlobalSettings from './MyGlobalSettings';


class TableRow extends Component
{
    constructor(props)
    {
        super(props);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleSubmit(event)
    {
        event.preventDefault();
        let uri = MyGlobalSettings.url + '/api/project/${this.props.project.id}';
        axios.delete(uri);
        browserHistory.push('/display-item');
    }

    render()
    {
        return (
            <tr>
                <td>
                    {this.props.project.id}
                </td>
                <td>
                    {this.props.project.name}
                </td>
                <td>
                    {this.props.project.information}
                </td>
                <td>
                    {this.props.project.deadline}
                </td>
                <td>
                    {this.props.project.type}
                </td>
                <td>
                    {this.props.project.status}
                </td>
                <td>
                    <form onSubmit={this.handleSubmit}>
                        <Link to={"/edit-item/"+this.props.project.id} className="btn btn-primary">Edit</Link>
                        <input type="submit" value="Delete" className="btn btn-danger"/>
                    </form>
                </td>
            </tr>
        );
    }
}
export default TableRow;