import React, { Component } from 'react';
import { Link, browserHistory } from 'react-router';

class TableRow extends Component
{
    constructor(props)
    {
        super(props);
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
                        <Link to={"/show-detail-item/"+this.props.project.id} className="btn btn-success">Show</Link>
                        <Link to={"/delete-item/"+this.props.project.id} className="btn btn-danger">Delete</Link>
                    </form>
                </td>
            </tr>
        );
    }
}
export default TableRow;