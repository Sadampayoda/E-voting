#include <iostream>
#include <vector>
using namespace std;

vector<string> compress(vector<string> chars) {
    if (chars.empty())
        return {};

    vector<string> compressed;
    string current_char = chars[0];
    int count = 1;

    for (int i = 1; i < chars.size(); ++i) {
        if (chars[i] == current_char) {
            count++;
        } else {
            compressed.push_back(current_char);
            compressed.push_back(to_string(count));
            current_char = chars[i];
            count = 1;
        }
    }

    compressed.push_back(current_char);
    compressed.push_back(to_string(count));

    return compressed;
}

int main() {
    int N;
    cout << "Masukkan banyak panjang: ";
    cin >> N;

    vector<string> chart;
    for (int i = 0; i < N; ++i) {
        string input_str;
        cout << "Masukkan string: ";
        cin >> input_str;
        chart.push_back(input_str);
    }

    vector<string> compressed_result = compress(chart);
    cout << "Hasil kompresi:\n";
    for (const string& str : compressed_result) {
        cout << str << " ";
    }
    cout << endl;

    cout << N << endl;

    return 0;
}
