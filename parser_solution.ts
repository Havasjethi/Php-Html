
const test = (text :string) => {

    const push = (s: string, replace: boolean = true) => {
        s.replace(' ', '');
        if (s !== '') {
            console.log(s);
            stack.push[s];
        }
    }

    let filler = '';
    let stack = [];
    const special: Array<string> = [' ', '"', '='];
    
    for (let i = 0; i != text.length; i++) {
        const c = text[i];

        if (c === ' ') {
            push(filler);
            filler = '';
        } else if (c === '=') {
            push(filler);
            filler = '';
            push('=');

        } else if (c === '"') {
            filler += '"';
            let n;

            do {
                i++;
                n = text[i];
                filler += n;
            }
            while (n !== '"' && i < text.length);

            // push(filler.substr(0, filler.length-1));
            push(filler);
            filler = '';
        } else {
            filler += c;
        }
    }
}

test('   a class  =  "w3-button w3-bar-item w3-light-grey" target="_blank" href="tryit.asp?filename=tryhtml_formatting_q"');

