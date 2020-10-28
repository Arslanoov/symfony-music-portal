import * as React from 'react';
import * as renderer from 'react-test-renderer';

import App from './App';

test("<App /> work fine", () => {
    const instance = renderer
        .create(<App />)
        .toTree();

    if (!("props" in instance.rendered)) {
        throw new Error();
    }

    expect(instance.rendered.props.children).toBe('Music Portal');
});
