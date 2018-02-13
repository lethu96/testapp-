import React, { Component } from 'react';
import { Link, browserHistory} from 'react-router';

class DeleteProject extends Component
{
    componentDidMount(){
        $('.page-header h1').text('Delete Product');
    }

    onDelete(){
        let current_url = window.location.href;
        let current_id = current_url.split("/").pop();
        console.log(current_id);
        axios.delete('http://localhost:8000/project/destroy/' + current_id).then(
            (response) => {
                browserHistory.push('/display-item');}
            );
    }

    notDelete(){
        browserHistory.push('/display-item');
    }

    render()
    {
    return (
        <div className='row'>
            <div className='col-md-3'></div>
            <div className='col-md-6'>
                <div className='panel panel-default'>
                    <div className='panel-body text-align-center'>Are you sure?</div>
                    <div className='panel-footer clearfix'>
                        <div className='text-align-center'>
                            <button onClick={this.onDelete}
                                className='btn btn-danger m-r-1em'>Yes</button>
                            <button onClick={this.notDelete}
                                className='btn btn-primary'>No</button>
                        </div>
                    </div>
                </div>
            </div>
            <div className='col-md-3'></div>
        </div>
    );
}


}

export default DeleteProject;